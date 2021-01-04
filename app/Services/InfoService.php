<?php

namespace Gameap\Services;

use \Illuminate\Http\Response;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class InfoService
{
    /**
     * Get GameAP Latest Release
     * 
     * @return string
     */
    public static function latestRelease()
    {
        $client = new Client();
        
        // TODO: Remove before beta
        try {
            $res = $client->get('http://www.gameap.ru/gameap_version.txt');
        } catch (RequestException $e) {
            return '';
        }

        if ($res->getStatusCode() == Response::HTTP_OK) {
             $lines = explode("\n", $res->getBody()->getContents());
             $parts = explode(': ', $lines[0]);
             $latest = $parts[1];
             
             return $latest;
        }
        
        // GitHub
        // TODO: Replace before beta
        try {
            $res = $client->get('https://api.github.com/repos/et-nik/gameap/releases/latest');
        } catch (RequestException $e) {
            return '';
        }

        if ($res->getStatusCode() == Response::HTTP_OK) {
            $result = json_decode($res->getBody()->getContents());

            if (!empty($result->tag_name)) {
                return $result->tag_name;
            } else {
                return '';
            }
        } else {
            return '';
        }
    }

    /**
     * @param $report
     */
//    static public function sendBugReport($report)
//    {
//        
//    }
}