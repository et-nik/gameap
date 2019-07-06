<?php

namespace Gameap\Services;

use Gameap\Models\Game;
use Gameap\Models\GameMod;
use Gameap\Exceptions\Services\GlobalApiException;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\HttpFoundation\Response;
use Config;

class GlobalApi
{
    /**
     * @return array
     * @throws GlobalApiException
     */
    public static function games()
    {
        try {
            $client = new Client(['headers' => ['Accept: application/json']]);
            $res = $client->get(config('app.global_api') . '/games');
            $status = $res->getStatusCode();
        } catch (ClientException $e) {
            throw new GlobalApiException($e->getMessage());
        }

        if ($status != Response::HTTP_OK) {
            throw new GlobalApiException('Unexpected HTTP status code: ' . $status);
        }

        $json = $res->getBody()->getContents();
        $results = json_decode($json, true);

        if (empty($results['success']) || $results['success'] != true) {
            throw new GlobalApiException('API Error');
        }

        return $results['data'];
    }

    /**
     * @param $summary
     * @param $description
     * @param $environment
     * @return bool
     * @throws GlobalApiException
     */
    public static function sendBug($summary, $description, $environment = '')
    {
        $version = Config::get('constants.AP_VERSION');

        $environment .= 'PHP version: ' . phpversion() . "\n";
        $environment .= php_uname() . "\n";

        $ar = compact('version', 'summary', 'description', 'environment');
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
            throw new GlobalApiException($e->getMessage());
        }

        if ($status != Response::HTTP_CREATED) {
            throw new GlobalApiException('Unexpected HTTP status code: ' . $status);
        }

        return true;
    }
}