<?php

namespace Gameap\UseCases;

use Gameap\Models\Server;
use Gameap\Repositories\ServerRepository;
use Gameap\UseCases\Commands\EditGameServerCommand;

class EditGameServer
{
    /**
     * @var ServerRepository
     */
    private $serverRepository;

    public function __construct(ServerRepository $serverRepository)
    {
        $this->serverRepository = $serverRepository;
    }

    public function __invoke(EditGameServerCommand $command): Server
    {
        $server = $this->serverRepository->find($command->id);

        $server->name = $command->name;
        $server->installed = $command->installed ?? $server->installed;
        $server->blocked = $command->blocked ?? $server->blocked;
        $server->enabled = $command->enabled ?? $server->enabled;
        $server->game_id = $command->gameId ?? $server->game_id;
        $server->game_mod_id = $command->gameModId;
        $server->server_ip = $command->serverIp;
        $server->server_port = $command->serverPort;
        $server->query_port = $command->queryPort;
        $server->rcon_port = $command->rconPort;
        $server->start_command = $command->startCommand;
        $server->dir = $command->dir;
        $server->su_user = $command->suUser;
        $server->rcon = $command->rcon ?? $server->rcon;

        $this->serverRepository->save($server);

        return $server;
    }
}
