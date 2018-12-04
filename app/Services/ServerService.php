<?php

namespace Gameap\Services;

use GameQ\GameQ;
use Gameap\Models\Server;
use Knik\Gameap\GdaemonCommands;
use Html;
use Gameap\Exceptions\Services\InvalidCommand;

class ServerService
{
    protected $gameq;
    protected $gdaemonCommands;

    public function __construct(GameQ $gameq, GdaemonCommands $gdaemonCommands)
    {
        $this->gameq = $gameq;
        $this->gdaemonCommands = $gdaemonCommands;
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

    /**
     * @param Server $server
     * @param string $command
     * @param array $extraData
     * @return string
     */
    public function replaceShortCodes(Server $server, string $command, array $extraData = [])
    {
        foreach ($extraData as $key => $value) {
            $command = str_replace('{' . $key . '}', $value, $command);
        }

        $replaceArray = [
            'host' => $server->server_ip,
            'port' => $server->server_port,
            'query_port' => $server->query_port,
            'rcon_port' => $server->rcon_port,
            'dir' => rtrim($server->dedicatedServer->work_path, '/') . '/' . ltrim($server->dir, '/'),
            'uuid' => $server->uuid,
            'uuid_short' => $server->uuid_short,
            'game' => $server->game_id,
            'user' => $server->su_user,
        ];

        foreach ($replaceArray as $key => $value) {
            $command = str_replace('{' . $key . '}', $value, $command);
        }

        return $command;
    }

    /**
     * @param Server $server
     * @param string $command
     * @param array $extraData
     * @return string
     *
     * @throws InvalidCommand
     */
    public function getCommand(Server $server, string $command, array $extraData = [])
    {
        $property = 'script_' . $command;
        if (isset($server->dedicatedServer->$property)) {
            $script = $server->dedicatedServer->$property;
            return $this->replaceShortCodes($server, $script, $extraData);
        }

        throw new InvalidCommand();
    }

    /**
     * @param Server $server
     * @return string
     */
    public function getConsoleLog(Server $server)
    {
        $this->gdaemonCommands->setConfig([
            'host' => $server->dedicatedServer->gdaemon_host,
            'port' => $server->dedicatedServer->gdaemon_port,
            'username' => $server->dedicatedServer->gdaemon_login,
            'password' => $server->dedicatedServer->gdaemon_password,
            'serverCertificate' => $server->dedicatedServer->gdaemon_server_cert,
            'localCertificate' => $server->dedicatedServer->clientCertificate->certificate,
            'privateKey' => $server->dedicatedServer->clientCertificate->private_key,
            'privateKeyPass' => $server->dedicatedServer->clientCertificate->private_key_pass,
            'timeout' => 10,
        ]);

        $command = $this->getCommand($server, 'get_console');
        $result = $this->gdaemonCommands->exec($command, $exitCode);

        return $result;
    }
}