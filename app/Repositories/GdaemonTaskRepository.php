<?php

namespace Gameap\Repositories;

use Gameap\Models\Server;
use Gameap\Models\GdaemonTask;

/**
 * Class GdaemonTaskRepository
*/
class GdaemonTaskRepository
{
    public function getAll($perPage = 20)
    {
        $gdaemonTasks = GdaemonTask::orderBy('id')->paginate($perPage);
        return $gdaemonTasks;
    }

    public function getById(int $id)
    {

    }

    /**
     * Create new starting of game server task
     *
     * @param Server $server
     * @param int $runAftId
     * @return int Gdaemon Task id
     */
    public function addServerStart(Server $server, int $runAftId = 0)
    {
        return GdaemonTask::create([
            'run_aft_id' => $runAftId,
            'dedicated_server_id' => $server->ds_id,
            'server_id' => $server->id,
            'task' => 'gsstart',
        ])->id;
    }

    public function addServerRestart(Server $server, int $runAftId = 0)
    {
        return GdaemonTask::create([
            'run_aft_id' => $runAftId,
            'dedicated_server_id' => $server->ds_id,
            'server_id' => $server->id,
            'task' => 'gsrest',
        ])->id;
    }

    public function addServerUpdate(Server $server, int $runAftId = 0)
    {
        return GdaemonTask::create([
            'run_aft_id' => $runAftId,
            'dedicated_server_id' => $server->ds_id,
            'server_id' => $server->id,
            'task' => 'gsinst',
        ])->id;
    }

    public function addServerDelete(Server $server, int $runAftId = 0)
    {
        return GdaemonTask::create([
            'run_aft_id' => $runAftId,
            'dedicated_server_id' => $server->ds_id,
            'server_id' => $server->id,
            'task' => 'gsdel',
        ])->id;
    }
}
