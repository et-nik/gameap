<?php

namespace Gameap\Http\Responses\GdaemonAPI;

class GameModResponse implements \JsonSerializable
{
    /** @var \Gameap\Models\GameMod */
    private $gameMod;

    /** @var string */
    private $os;

    public function __construct(\Gameap\Models\GameMod $gameMod, string $os = 'linux')
    {
        $this->gameMod = $gameMod;
        $this->os = $os;
    }

    public function jsonSerialize()
    {
        $remoteRepository = '';
        $localRepository = '';
        $defaultStartCmd = '';
        if ($this->os === 'linux') {
            $remoteRepository = $this->gameMod->remote_repository_linux;
            $localRepository = $this->gameMod->local_repository_linux;
            $defaultStartCmd = $this->gameMod->start_cmd_linux;
        } elseif ($this->os === 'windows') {
            $remoteRepository = $this->gameMod->remote_repository_windows;
            $localRepository = $this->gameMod->local_repository_windows;
            $defaultStartCmd = $this->gameMod->start_cmd_windows;
        }

        return [
            'id' => $this->gameMod->id,
            'game_code' => $this->gameMod->game_code,
            'name' => $this->gameMod->name,
            'vars' => $this->gameMod->vars,
            'remote_repository' => $remoteRepository,
            'local_repository' => $localRepository,
            'default_start_cmd' => $defaultStartCmd,
            'default_start_cmd_linux' => $this->gameMod->start_cmd_linux,
            'default_start_cmd_windows' => $this->gameMod->start_cmd_windows,
        ];
    }
}
