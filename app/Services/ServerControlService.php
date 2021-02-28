<?php

namespace Gameap\Services;

use Gameap\Exceptions\Repositories\GdaemonTaskRepository\EmptyServerStartCommandException;
use Gameap\Exceptions\Repositories\GdaemonTaskRepository\GdaemonTaskRepositoryException;
use Gameap\Exceptions\Repositories\GdaemonTaskRepository\InvalidServerStartCommandException;
use Gameap\Exceptions\Repositories\RecordExistExceptions;
use Gameap\Models\GdaemonTask;
use Gameap\Models\Server;
use Gameap\Models\ServerSetting;
use Gameap\Repositories\GdaemonTaskRepository;
use Gameap\Repositories\ServerRepository;

class ServerControlService
{
    /** @var ServerRepository */
    public $repository;

    /** @var GdaemonTaskRepository */
    public $gdaemonTaskRepository;

    public function __construct(GdaemonTaskRepository $gdaemonTaskRepository)
    {
        $this->gdaemonTaskRepository = $gdaemonTaskRepository;
    }

    /**
     * @throws EmptyServerStartCommandException
     * @throws InvalidServerStartCommandException
     * @throws RecordExistExceptions|GdaemonTaskRepositoryException
     */
    public function start(Server $server): int
    {
        if ($this->gdaemonTaskRepository->taskExists($server, GdaemonTask::TASK_SERVER_START, [
            GdaemonTask::STATUS_WAITING,
            GdaemonTask::STATUS_WORKING
        ])) {
            $gdaemonTaskId = $this->gdaemonTaskRepository->getFirstWaitingOrWorkingTaskId(
                $server->id,
                GdaemonTask::TASK_SERVER_START
            );
        } else {
            $this->setAutostartSetting($server, true);
            $gdaemonTaskId = $this->gdaemonTaskRepository->addServerStart($server);
        }

        return $gdaemonTaskId;
    }

    /**
     * @throws EmptyServerStartCommandException
     * @throws RecordExistExceptions|GdaemonTaskRepositoryException
     */
    public function stop(Server $server): int
    {
        if ($this->gdaemonTaskRepository->taskExists($server, GdaemonTask::TASK_SERVER_STOP, [
            GdaemonTask::STATUS_WAITING,
            GdaemonTask::STATUS_WORKING
        ])) {
            $gdaemonTaskId = $this->gdaemonTaskRepository->getFirstWaitingOrWorkingTaskId(
                $server->id,
                GdaemonTask::TASK_SERVER_STOP
            );
        } else {
            $this->setAutostartSetting($server, false);
            $gdaemonTaskId = $this->gdaemonTaskRepository->addServerStop($server);
        }


        return $gdaemonTaskId;
    }

    /**
     * @throws EmptyServerStartCommandException
     * @throws InvalidServerStartCommandException
     * @throws RecordExistExceptions
     */
    public function restart(Server $server): int
    {
        if ($this->gdaemonTaskRepository->taskExists($server, GdaemonTask::TASK_SERVER_RESTART, [
            GdaemonTask::STATUS_WAITING,
            GdaemonTask::STATUS_WORKING
        ])) {
            $gdaemonTaskId = $this->gdaemonTaskRepository->getFirstWaitingOrWorkingTaskId(
                $server->id,
                GdaemonTask::TASK_SERVER_RESTART
            );
        } else {
            $this->setAutostartSetting($server, true);
            $gdaemonTaskId = $this->gdaemonTaskRepository->addServerRestart($server);
        }

        return $gdaemonTaskId;
    }

    /**
     * @throws EmptyServerStartCommandException
     * @throws InvalidServerStartCommandException
     * @throws RecordExistExceptions
     */
    public function update(Server $server): int
    {
        if ($this->gdaemonTaskRepository->taskExists($server, GdaemonTask::TASK_SERVER_UPDATE, [
            GdaemonTask::STATUS_WAITING,
            GdaemonTask::STATUS_WORKING
        ])) {
            $gdaemonTaskId = $this->gdaemonTaskRepository->getFirstWaitingOrWorkingTaskId(
                $server->id,
                GdaemonTask::TASK_SERVER_UPDATE
            );
        } else {
            $this->setAutostartSetting($server, true);
            $gdaemonTaskId = $this->gdaemonTaskRepository->addServerUpdate($server);
        }

        return $gdaemonTaskId;
    }

    private function setAutostartSetting(Server $server, bool $autostartValue): void
    {
        $autostartSetting = $server->settings->where('name', 'autostart')->first()
            ?? new ServerSetting([
                'server_id' => $server->id,
                'name'      => 'autostart',
                'value'     => $autostartValue,
            ]);

        if ($autostartSetting->value === $autostartValue) {
            $autostartCurrentSetting = $server->settings->where('name', 'autostart_current')->first()
                ?? new ServerSetting([
                    'server_id' => $server->id,
                    'name'      => 'autostart_current',
                    'value'     => $autostartValue,
                ]);

            $autostartCurrentSetting->save();
        }
    }
}
