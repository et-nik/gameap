<?php

namespace Gameap\Services;

use GameQ\GameQ;
use Gameap\Models\Server;
use Knik\Gameap\GdaemonCommands;
use Html;
use Gameap\Exceptions\Services\InvalidCommandException;
use Gameap\Exceptions\Services\ServerInactiveException;
use Storage;

class ServerService
{
    /**
     * @var GameQ
     */
    protected $gameq;

    /**
     * @var GdaemonCommands
     */
    protected $gdaemonCommands;

    /**
     * @var string
     */
    protected $storageDisk = 'local';

    /**
     * ServerService constructor.
     *
     * @param GameQ $gameq
     * @param GdaemonCommands $gdaemonCommands
     */
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
            'dir' => $server->full_path,
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
     * @throws InvalidCommandException
     */
    public function getCommand(Server $server, string $command, array $extraData = [])
    {
        $property = 'script_' . $command;
        if (isset($server->dedicatedServer->$property)) {
            $script = $server->dedicatedServer->$property;
            return $this->replaceShortCodes($server, $script, $extraData);
        }

        throw new InvalidCommandException();
    }

    /**
     * @param Server $server
     * @return string
     */
    public function getConsoleLog(Server $server)
    {
        $this->checkServer($server);
        $this->configureGdaemon($server);

        $command = $this->getCommand($server, 'get_console');
        $result = $this->gdaemonCommands->exec($command, $exitCode);

        return $result;
    }

    /**
     * @param Server $server
     * @param string $command
     * @return string
     */
    public function sendConsoleCommand(Server $server, string $command)
    {
        $this->checkServer($server);
        $this->configureGdaemon($server);

        $command = $this->getCommand($server, 'send_command', ['command' => $command]);
        $result = $this->gdaemonCommands->exec($command, $exitCode);

        return $exitCode == 0 ? true: false;
    }

    /**
     * Setting up gdaemon commands configuration
     *
     * @param Server $server
     */
    private function configureGdaemon(Server $server)
    {
        $this->gdaemonCommands->setConfig(
            $server->server->dedicatedServer->gdaemonSettings($this->storageDisk)
        );
    }

    /**
     * @param Server $server
     * @throws ServerInactiveException
     */
    private function checkServer(Server $server)
    {
        if ($server->processActive() == false) {
            throw new ServerInactiveException('Server is down');
        }
    }
}