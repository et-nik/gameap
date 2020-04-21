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
     * The ServerRepository instance.
     *
     * @var \Gameap\Repositories\ServerRepository
     */
    public $repository;

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

    /**
     * @param Server $server
     * @return int
     *
     * @throws EmptyServerStartCommandException
     * @throws InvalidServerStartCommandException
     * @throws RecordExistExceptions
     */
    public function start(Server $server)
    {
        $autostartSetting = $server->settings->where('name', 'autostart')->first()
            ?? new ServerSetting([
                'server_id' => $server->id,
                'name'      => 'autostart',
                'value'     => true,
            ]);

        if ($autostartSetting->value == true) {
            $autostartCurrentSetting = $server->settings->where('name', 'autostart_current')->first()
                ?? new ServerSetting([
                    'server_id' => $server->id,
                    'name'      => 'autostart_current',
                    'value'     => true,
                ]);

            $autostartCurrentSetting->value = true;
            $autostartCurrentSetting->save();
        }

        $gdaemonTaskId = $this->gdaemonTaskRepository->addServerStart($server);
        return $gdaemonTaskId;
    }

    /**
     * @param Server $server
     * @return int
     *
     * @throws EmptyServerStartCommandException
     * @throws InvalidServerStartCommandException
     * @throws RecordExistExceptions
     */
    public function stop(Server $server)
    {
        $autostartCurrentSetting = $server->settings->where('name', 'autostart_current')->first();
        $autostartCurrentSetting->value = false;
        $autostartCurrentSetting->save();

        $gdaemonTaskId = $this->gdaemonTaskRepository->addServerStop($server);
        return $gdaemonTaskId;
    }

    /**
     * @param Server $server
     * @return int
     *
     * @throws EmptyServerStartCommandException
     * @throws InvalidServerStartCommandException
     * @throws RecordExistExceptions
     */
    public function restart(Server $server)
    {
        $autostartSetting = $server->settings->where('name', 'autostart')->first()
            ?? new ServerSetting([
                'server_id' => $server->id,
                'name'      => 'autostart',
                'value'     => true,
            ]);

        if ($autostartSetting->value == true) {
            $autostartCurrentSetting = $server->settings->where('name', 'autostart_current')->first()
                ?? new ServerSetting([
                    'server_id' => $server->id,
                    'name'      => 'autostart_current',
                    'value'     => true,
                ]);

            $autostartCurrentSetting->save();
        }

        $gdaemonTaskId = $this->gdaemonTaskRepository->addServerRestart($server);
        return $gdaemonTaskId;
    }

    /**
     * @param Server $server
     * @return int
     *
     * @throws EmptyServerStartCommandException
     * @throws InvalidServerStartCommandException
     * @throws RecordExistExceptions
     */
    public function update(Server $server)
    {
        $gdaemonTaskId = $this->gdaemonTaskRepository->addServerUpdate($server);
        return $gdaemonTaskId;
    }

}