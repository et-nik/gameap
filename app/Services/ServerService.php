<?php

namespace Gameap\Services;

use GameQ\GameQ;
use Gameap\Models\Server;
use Html;

class ServerService
{
    protected $gameq;

    public function __construct(GameQ $gameq)
    {
        $this->gameq = $gameq;
    }

    /**
     * @param Server $server
     * @return array
     */
    public function query(Server $server)
    {
        $query = $this->gameq->setOption('timeout', 5)
            ->addServer([
                'type' => $server->game->engine,
                'host' => "{$server->server_ip}:{$server->query_port}",
            ])
            ->process();

        $serverResult = $query["{$server->server_ip}:{$server->query_port}"];

        if ($serverResult['gq_online']) {
            $result = [
                'status' => $serverResult['gq_online'] ? 'online' : 'offline',
                'hostname' => $serverResult['gq_hostname'],
                'map' => $serverResult['gq_mapname'],
                'players' => $serverResult['gq_numplayers'] . '/' . $serverResult['gq_maxplayers'],
                'version' => isset($serverResult['version']) ? $serverResult['version'] : null,
                'password' => $serverResult['gq_password'] ? 'yes' : 'no',
                'joinlink' => $serverResult['gq_joinlink'],
            ];
        } else {
            $result = [
                'status' => 'offline',
            ];
        }

        return $result;
    }
}