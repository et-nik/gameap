<?php

namespace Gameap\Services;

use Config;
use Gameap\Exceptions\Services\ResponseException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\RequestOptions;
use Symfony\Component\HttpFoundation\Response;

class GlobalApi
{
    private const CONFIG_GLOBAL_API_NAME = 'app.global_api';

    /**
     * @return array
     * @throws ResponseException|\GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     */
    public static function games()
    {
        try {
            $client = new Client(['headers' => ['Accept: application/json']]);
            $res    = $client->get(config(self::CONFIG_GLOBAL_API_NAME) . '/games');
            $status = $res->getStatusCode();
        } catch (ClientException $e) {
            throw new ResponseException($e->getMessage());
        }

        if ($status !== Response::HTTP_OK) {
            throw new ResponseException('Unexpected HTTP status code: ' . $status);
        }

        $json    = $res->getBody()->getContents();
        $results = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        if (empty($results['success']) || $results['success'] !== true) {
            throw new ResponseException('API Error');
        }

        return $results['data'];
    }

    /**
     * @param $summary
     * @param $description
     * @param $environment
     * @return bool
     * @throws ResponseException
     */
    public static function sendBug($summary, $description, $environment = '')
    {
        $version = Config::get('constants.AP_VERSION') . ' [' . Config::get('constants.AP_DATE') . ']';

        $environment .= 'PHP version: ' . PHP_VERSION . "\n";
        $environment .= php_uname() . "\n";

        try {
            $client = new Client(['headers' => ['Accept' => 'application/json']]);

            $res = $client->post(
                config('app.global_api') . '/bugs',
                [
                    RequestOptions::JSON => compact('version', 'summary', 'description', 'environment'),
                ]
            );

            $status = $res->getStatusCode();
        } catch (ClientException $e) {
            throw new ResponseException($e->getMessage());
        }

        if ($status !== Response::HTTP_CREATED) {
            throw new ResponseException('Unexpected HTTP status code: ' . $status);
        }

        return true;
    }
}
