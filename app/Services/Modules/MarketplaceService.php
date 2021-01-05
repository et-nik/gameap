<?php

namespace Gameap\Services\Modules;

use Gameap\Exceptions\GameapException;
use Gameap\Exceptions\InvalidArgumentValueException;
use Gameap\Exceptions\NotFoundException;
use Gameap\Exceptions\Services\ResponseException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MarketplaceService
{
    public const CONFIG_REPOSITORIES_NAME = 'app.modules_repositories';

    /** @var Client */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getList(): iterable
    {
        $repositories = Config::get(self::CONFIG_REPOSITORIES_NAME);

        $modules = [];
        foreach ($repositories as $repository) {
            $modules[] = $this->loadRemote($repository . '/index.json');
        }

        return array_merge(...$modules);
    }

    public function findModule(string $moduleID): ?array
    {
        $repositories = Config::get(self::CONFIG_REPOSITORIES_NAME);

        foreach ($repositories as $repository) {
            $modules = $this->loadRemote($repository . '/index.json');

            if (array_key_exists($moduleID, $modules)) {
                return $this->getModule($repository, $moduleID);
            }
        }

        return null;
    }

    public function getModule(string $repository, string $moduleID): array
    {
        return $this->loadRemote($repository . '/modules/' . $moduleID . '.json');
    }

    public function downloadModule(string $moduleID, string $version): string
    {
        $module = $this->findModule($moduleID);

        if ($module === null) {
            throw new NotFoundException('Module not found');
        }

        if (!array_key_exists($version, $module['versions'])) {
            throw new InvalidArgumentValueException('Invalid module version');
        }

        $mirrors = $module['versions'][$version]['mirrors'];

        $filePath = tempnam(sys_get_temp_dir(), $moduleID);
        foreach ($mirrors as $mirror) {
            $result = $this->client->request(Request::METHOD_GET, $mirror, ['sink' => $filePath]);

            if ($result->getStatusCode() === Response::HTTP_OK) {
                return $filePath;
            }
        }

        throw new GameapException('Unable to download module');
    }

    /**
     * @param string $uri
     * @return array
     * @throws ResponseException
     * @throws GuzzleException
     * @throws \JsonException
     */
    private function loadRemote(string $uri): array
    {
        $response = $this->client->request(
            Request::METHOD_GET,
            $uri,
            ['headers' => ['Accept: application/json']]
        );

        if ($response->getStatusCode() !== Response::HTTP_OK) {
            throw new ResponseException('Unexpected HTTP status code: ' . $response->getStatusCode());
        }

        return json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }
}
