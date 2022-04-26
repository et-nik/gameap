<?php

namespace Gameap\UseCases;

use Gameap\Helpers\ServerHelper;
use Gameap\Models\Server;
use Gameap\Repositories\GameModRepository;
use Gameap\Repositories\NodeRepository;
use Gameap\Repositories\GdaemonTaskRepository;
use Gameap\Repositories\ServerRepository;
use Gameap\UseCases\Commands\CreateGameServerCommand;
use Illuminate\Support\Str;

class CreateGameServer
{
    public const DEFAULT_RCON_PASSWORD_LENGTH = 10;

    /** @var GdaemonTaskRepository */
    protected $gdaemonTaskRepository;

    /** @var ServerRepository */
    protected $serverRepository;

    /** @var NodeRepository */
    protected $nodeRepository;

    /** @var GameModRepository */
    protected $gameModRepository;

    public function __construct(GdaemonTaskRepository $gdaemonTaskRepository, ServerRepository $serverRepository, NodeRepository $nodeRepository, GameModRepository $gameModRepository)
    {
        $this->gdaemonTaskRepository = $gdaemonTaskRepository;
        $this->serverRepository = $serverRepository;
        $this->nodeRepository = $nodeRepository;
        $this->gameModRepository = $gameModRepository;
    }

    public function __invoke(CreateGameServerCommand $command)
    {
        $server = new Server();

        $server->uuid               = Str::orderedUuid()->toString();
        $server->uuid_short         = Str::substr($server->uuid, 0, 8);
        $server->ds_id              = $command->dsId;
        $server->name               = $command->name;
        $server->game_id            = $command->gameId;
        $server->game_mod_id        = $command->gameModId;
        $server->server_ip          = $command->serverIp;
        $server->server_port        = $command->serverPort;
        $server->query_port         = $command->queryPort;
        $server->rcon_port          = $command->rconPort;
        $server->su_user            = $command->suUser;

        $server->enabled = true;
        $server->blocked = false;

        if (empty($command->rcon)) {
            $server->rcon = Str::random(self::DEFAULT_RCON_PASSWORD_LENGTH);
        } else {
            $server->rcon = $command->rcon;
        }

        $node = $this->nodeRepository->findById($command->dsId);

        if (empty($command->startCommand)) {
            $gameMod = $this->gameModRepository->getById($command->gameModId);

            $server->start_command =
                $node->isLinux()
                    ? $gameMod->start_cmd_nix
                    : $gameMod->start_cmd_win;
        } else {
            $server->start_command = $command->startCommand;
        }

        if (empty($command->dir)) {
            $server->dir = 'servers/' . $server->uuid;
        } else {
            $server->dir = $command->dir;
        }

        if ($command->install) {
            $server->installed = false;
        }

        $this->serverRepository->save($server);

        if ($command->install) {
            $this->gdaemonTaskRepository->addServerInstall($server);
        }
    }
}
