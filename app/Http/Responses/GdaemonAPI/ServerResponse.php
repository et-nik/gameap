<?php

namespace Gameap\Http\Responses\GdaemonAPI;

use Gameap\Models\Game;
use Gameap\Models\GameMod;
use Gameap\Models\Server;
use Symfony\Component\Serializer\SerializerInterface;

class ServerResponse implements \JsonSerializable
{
    /** @var Server */
    private $server;

    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    public function jsonSerialize()
    {
        $gameModResponse = new GameModResponse($this->server->gameMod, $this->server->dedicatedServer->os);
        $gameResponse = new GameResponse($this->server->game, $this->server->dedicatedServer->os);

        return [
            'id' => $this->server->id,
            'uuid' => $this->server->uuid,
            'uuid_short' => $this->server->uuid_short,
            'enabled' => $this->server->enabled,
            'installed' => $this->server->installed,
            'blocked' => $this->server->blocked,
            'name' => $this->server->name,
            'ds_id' => $this->server->ds_id,
            'game_id' => $this->server->game_id,
            'game_mod_id' => $this->server->game_mod_id,
            'expires' => $this->server->expires,
            'server_ip' => $this->server->server_ip,
            'server_port' => $this->server->server_port,
            'query_port' => $this->server->query_port,
            'rcon_port' => $this->server->rcon_port,
            'rcon' => $this->server->rcon,
            'dir' => $this->server->dir,
            'su_user' => $this->server->su_user,
            'cpu_limit' => $this->server->cpu_limit,
            'ram_limit' => $this->server->ram_limit,
            'net_limit' => $this->server->net_limit,
            'start_command' => $this->server->start_command,
            'stop_command' => $this->server->stop_command,
            'force_stop_command' => $this->server->force_stop_command,
            'restart_command' => $this->server->restart_command,
            'process_active' => $this->server->process_active,
            'last_process_check' => $this->server->last_process_check,
            'vars' => $this->server->vars,
            'created_at' => $this->server->created_at,
            'updated_at' => $this->server->updated_at,
            'deleted_at' => $this->server->deleted_at,
            'settings' => $this->server->settings,
            'game' => $gameResponse->jsonSerialize(),
            'game_mod' => $gameModResponse->jsonSerialize(),
        ];
    }
}
