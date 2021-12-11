<?php

namespace Gameap\Services;

use Gameap\Exceptions\Repositories\GdaemonTaskRepository\EmptyServerStartCommandException;
use Gameap\Exceptions\Repositories\GdaemonTaskRepository\InvalidServerStartCommandException;
use Gameap\Exceptions\Repositories\RecordExistExceptions;
use Gameap\Models\Server;
use Gameap\Models\ServerSetting;
use Gameap\Repositories\GdaemonTaskRepository;

class ServerControlService
{
    /**
     * The GdaemonTaskRepository instance.
     *
     * @var GdaemonTaskRepository
     */
    public $gdaemonTaskRepository;

    public function __construct(GdaemonTaskRepository $gdaemonTaskRepository)
    {
        $this->gdaemonTaskRepository = $gdaemonTaskRepository;
    }

    public function start(Server $server): int
    {
        $autostartSetting = $server->getSetting(Server::AUTOSTART_SETTING_KEY);

        if ($autostartSetting->value == true) {
            $autostartCurrentSetting = $server->getSetting(Server::AUTOSTART_CURRENT_SETTING_KEY);
            $autostartCurrentSetting->value = true;
            $autostartCurrentSetting->save();
        }

        return $this->gdaemonTaskRepository->addServerStart($server);
    }

    public function stop(Server $server): int
    {
        $autostartCurrentSetting = $server->getSetting(Server::AUTOSTART_CURRENT_SETTING_KEY);
        $autostartCurrentSetting->value = false;
        $autostartCurrentSetting->save();

        return $this->gdaemonTaskRepository->addServerStop($server);
    }

    public function restart(Server $server): int
    {
        $autostartSetting = $server->getSetting(Server::AUTOSTART_SETTING_KEY);

        if ($autostartSetting->value) {
            $autostartCurrentSetting = $server->getSetting(Server::AUTOSTART_CURRENT_SETTING_KEY);
            $autostartCurrentSetting->value = true;
            $autostartCurrentSetting->save();
        }

        return $this->gdaemonTaskRepository->addServerRestart($server);
    }

    public function update(Server $server): int
    {
        $gdaemonTaskId = $this->gdaemonTaskRepository->addServerUpdate($server);
        return $gdaemonTaskId;
    }

    public function install(Server $server): int
    {
        $gdaemonTaskId = $this->gdaemonTaskRepository->addServerInstall($server);
        return $gdaemonTaskId;
    }
}
