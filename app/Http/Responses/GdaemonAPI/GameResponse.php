<?php

namespace Gameap\Http\Responses\GdaemonAPI;

use Gameap\Models\Game;

class GameResponse implements \JsonSerializable
{
    /** @var Game */
    private $game;

    private $os;

    public function __construct(Game $game, string $os = 'linux')
    {
        $this->game = $game;
        $this->os = $os;
    }

    public function jsonSerialize()
    {
        $remoteRepository = '';
        $localRepository = '';
        $steamAppId = '';

        if ($this->os === 'linux') {
            $remoteRepository = $this->game->remote_repository_linux;
            $localRepository = $this->game->local_repository_linux;
            $steamAppId = $this->game->steam_app_id_linux;
        } elseif ($this->os === 'windows') {
            $remoteRepository = $this->game->remote_repository_windows;
            $localRepository = $this->game->local_repository_windows;
            $steamAppId = $this->game->steam_app_id_windows;
        }

        return [
            'code' => $this->game->code,
            'start_code' => $this->game->start_code,
            'name' => $this->game->name,
            'engine' => $this->game->engine,
            'engine_version' => $this->game->engine_version,
            'remote_repository' => $remoteRepository,
            'local_repository' => $localRepository,
            'steam_app_id' => $steamAppId,
            'steam_app_set_config' => $this->game->steam_app_set_config,
        ];
    }
}
