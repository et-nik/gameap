<?php

namespace Gameap\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Response;
use Psr\Log\LoggerInterface;

class InfoService
{
    private const GAMEAP_LATEST_VERSION_URI = 'http://www.gameap.ru/gameap_version.txt';
    private const GITHUB_LATEST_VERSION_URI = 'https://api.github.com/repos/et-nik/gameap/releases/latest';

    /** @var Client */
    private $client;

    /** @var LoggerInterface */
    private $logger;

    private $timeoutInSeconds = 1;

    public function __construct(Client $client, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->logger = $logger;
    }

    public function latestRelease(): string
    {
        $version = $this->loadVersionFromGameap();

        if ($version === '') {
            $version = $this->loadVersionFromGithub();
        }

        return $version;
    }

    private function loadVersionFromGameap(): string
    {
        try {
            $res = $this->client->get(
                self::GAMEAP_LATEST_VERSION_URI,
                [
                    RequestOptions::TIMEOUT => $this->timeoutInSeconds,
                    RequestOptions::CONNECT_TIMEOUT => $this->timeoutInSeconds,
                ]
            );
        } catch (GuzzleException $e) {
            $this->logger->error($e->getMessage());
            return '';
        }

        if ($res->getStatusCode() === Response::HTTP_OK) {
            $lines  = explode("\n", $res->getBody()->getContents());
            $parts  = explode(': ', $lines[0]);
            return $parts[1];
        }

        return '';
    }

    private function loadVersionFromGithub(): string
    {
        try {
            $res = $this->client->get(
                self::GITHUB_LATEST_VERSION_URI,
                [
                    RequestOptions::TIMEOUT => $this->timeoutInSeconds,
                    RequestOptions::CONNECT_TIMEOUT => $this->timeoutInSeconds,
                ]
            );
        } catch (GuzzleException $e) {
            $this->logger->error($e->getMessage());
            return '';
        }

        if ($res->getStatusCode() === Response::HTTP_OK) {
            $result = json_decode($res->getBody()->getContents());

            if (!empty($result->tag_name)) {
                return $result->tag_name;
            }
        }

        return '';
    }
}
