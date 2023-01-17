<?php

namespace Gameap\Services;

use Gameap\Exceptions\Services\EmptyCommandException;
use Gameap\Exceptions\Services\InvalidCommandException;
use Gameap\Exceptions\Services\ServerInactiveException;
use Gameap\Models\Server;
use GameQ\Exception\Protocol as GameqProtocolException;
use GameQ\Exception\Query as GameqQueryException;
use GameQ\Exception\Server as GameqServerException;
use GameQ\GameQ;
use Knik\Gameap\GdaemonCommands;
use Storage;

class ServerService
{
    public const CONSOLE_MAX_SYMBOLS = 10000;

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
        $this->gameq           = $gameq;
        $this->gdaemonCommands = $gdaemonCommands;
    }

    /**
     * Add default server disk
     *
     * @param Server $server
     */
    public function registerDisk(Server $server): void
    {
        foreach ($server->file_manager_disks as $diskName => $diskConfig) {
            if (empty(config("filesystems.disks.{$diskName}"))) {
                config(["filesystems.disks.{$diskName}" => $diskConfig]);
            }
        }
    }

    /**
     * @param Server $server
     * @return array|string[]
     * @throws \Exception
     */
    public function query(Server $server): array
    {
        $host = "{$server->server_ip}:{$server->query_port}";

        try {
            $query = $this->gameq->setOption('timeout', 5)
                ->addServer([
                    'type' => $server->game->engine,
                    'host' => $host,
                ])
                ->process();
        } catch (GameqServerException | GameqQueryException | GameqProtocolException $exception) {
            return [
                'status' => 'query not supported for this game',
            ];
        }


        $serverResult = $query[$host] ?? null;

        if (!empty($serverResult['gq_online'])) {
            $result = [
                'status'   => $serverResult['gq_online'] ? 'online' : 'offline',
                'hostname' => $serverResult['gq_hostname'],
                'map'      => $serverResult['gq_mapname'],
                'players'  => $serverResult['gq_numplayers'] . '/' . $serverResult['gq_maxplayers'],
                'version'  => $serverResult['version'] ?? null,
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
    public function replaceShortCodes(Server $server, string $command, array $extraData = []): string
    {
        foreach ($extraData as $key => $value) {
            $command = str_replace('{' . $key . '}', $value, $command);
        }

        $replaceArray = [
            'node_work_path'    => $server->dedicatedServer->work_path,
            'node_tools_path'   => $server->dedicatedServer->work_path . "/tools",
            'host'              => $server->server_ip,
            'port'              => $server->server_port,
            'query_port'        => $server->query_port,
            'rcon_port'         => $server->rcon_port,
            'dir'               => $server->full_path,
            'uuid'              => $server->uuid,
            'uuid_short'        => $server->uuid_short,
            'game'              => $server->game_id,
            'user'              => $server->su_user,
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
     * @throws EmptyCommandException
     */
    public function getCommand(Server $server, string $command, array $extraData = []): string
    {
        $property   = 'script_' . $command;
        $attributes = $server->dedicatedServer->getAttributes();

        if (array_key_exists($property, $attributes)) {
            $script = $server->dedicatedServer->getAttribute($property);

            if (empty($script)) {
                throw new EmptyCommandException();
            }

            return $this->replaceShortCodes($server, $script, $extraData);
        }

        throw new InvalidCommandException();
    }

    /**
     * @param Server $server
     * @return string
     * @throws ServerInactiveException|InvalidCommandException
     */
    public function getConsoleLog(Server $server): string
    {
        $this->checkServer($server);
        $this->configureGdaemon($server);

        try {
            $command = $this->getCommand($server, 'get_console');
            $result  = $this->gdaemonCommands->exec($command, $exitCode);
        } catch (EmptyCommandException $e) {
            $this->registerDisk($server);
            $result = Storage::disk('server')->get('output.txt');
        }

        if (mb_strlen($result) > self::CONSOLE_MAX_SYMBOLS) {
            $result = mb_substr($result, mb_strlen($result) - self::CONSOLE_MAX_SYMBOLS, self::CONSOLE_MAX_SYMBOLS);
        }

        // Fix
        // Malformed UTF-8 characters, possibly incorrectly encoded
        $result = mb_convert_encoding($result, 'UTF-8', 'UTF-8');

        return $result;
    }

    /**
     * @param Server $server
     * @param string $command
     * @return bool
     *
     * @throws InvalidCommandException
     * @throws ServerInactiveException
     */
    public function sendConsoleCommand(Server $server, string $command): bool
    {
        $this->checkServer($server);
        $this->configureGdaemon($server);

        try {
            $command = $this->getCommand($server, 'send_command', ['command' => $command]);
            $this->gdaemonCommands->exec($command, $exitCode);
        } catch (EmptyCommandException $e) {
            $this->registerDisk($server);

            if (Storage::disk('server')->put('input.txt', $command)) {
                // Success
                $exitCode = 0;
            } else {
                // Failure
                $exitCode = 1;
            }
        }

        return $exitCode === 0;
    }

    /**
     * Setting up gdaemon commands configuration
     *
     * @param Server $server
     */
    private function configureGdaemon(Server $server): void
    {
        $this->gdaemonCommands->setConfig(
            $server->dedicatedServer->gdaemonSettings($this->storageDisk)
        );
    }

    /**
     * @param Server $server
     * @throws ServerInactiveException
     */
    private function checkServer(Server $server): void
    {
        if ($server->processActive() === false) {
            throw new ServerInactiveException('Server is down');
        }
    }
}
