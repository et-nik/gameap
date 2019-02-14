<?php

namespace Gameap\Repositories;

use Gameap\Models\Server;
use Gameap\Models\GdaemonTask;
use Gameap\Models\DedicatedServer;
use Gameap\Exceptions\Repositories\RecordExistExceptions;

/**
 * Class GdaemonTaskRepository
*/
class GdaemonTaskRepository
{
    protected $model;

    public function __construct(GdaemonTask $gdaemonTask)
    {
        $this->model = $gdaemonTask;
    }
    
    public function getAll($perPage = 20)
    {
        $gdaemonTasks = GdaemonTask::orderBy('id', 'DESC')->paginate($perPage);
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
     * @return int Gdaemon Task ID
     */
    public function addServerStart(Server $server, int $runAftId = 0)
    {
        $this->workingTaskNotExistOrFail($server->id, GdaemonTask::TASK_SERVER_START, 'Server start task is already exists');
        
        return GdaemonTask::create([
            'run_aft_id' => $runAftId,
            'dedicated_server_id' => $server->ds_id,
            'server_id' => $server->id,
            'task' => GdaemonTask::TASK_SERVER_START,
        ])->id;
    }

    /**
     * Create new stopping of game server task
     *
     * @param Server $server
     * @param int $runAftId
     * @return int Gdaemon Task ID
     */
    public function addServerStop(Server $server, int $runAftId = 0)
    {
        $this->workingTaskNotExistOrFail($server->id, GdaemonTask::TASK_SERVER_STOP, 'Server stop task is already exists');

        return GdaemonTask::create([
            'run_aft_id' => $runAftId,
            'dedicated_server_id' => $server->ds_id,
            'server_id' => $server->id,
            'task' => GdaemonTask::TASK_SERVER_STOP,
        ])->id;
    }

    /**
     * @param Server $server
     * @param int    $runAftId
     *
     * @return int Gdaemon Task ID
     */
    public function addServerRestart(Server $server, int $runAftId = 0)
    {
        $this->workingTaskNotExistOrFail($server->id, GdaemonTask::TASK_SERVER_RESTART, 'Server restart task is already exists');
        
        return GdaemonTask::create([
            'run_aft_id' => $runAftId,
            'dedicated_server_id' => $server->ds_id,
            'server_id' => $server->id,
            'task' => GdaemonTask::TASK_SERVER_RESTART,
        ])->id;
    }

    /**
     * @param Server $server
     * @param int    $runAftId
     *
     * @return int Gdaemon Task ID
     */
    public function addServerUpdate(Server $server, int $runAftId = 0)
    {
        $this->workingTaskNotExistOrFail($server->id, GdaemonTask::TASK_SERVER_UPDATE, 'Server update/install task is already exists');
        
        return GdaemonTask::create([
            'run_aft_id' => $runAftId,
            'dedicated_server_id' => $server->ds_id,
            'server_id' => $server->id,
            'task' => GdaemonTask::TASK_SERVER_UPDATE,
        ])->id;
    }

    /**
     * @param Server $server
     * @param int    $runAftId
     *
     * @return int Gdaemon Task ID
     */
    public function addServerDelete(Server $server, int $runAftId = 0)
    {
        $this->workingTaskNotExistOrFail($server->id, GdaemonTask::TASK_SERVER_DELETE, 'Server delete task is already exists');
        
        return GdaemonTask::create([
            'run_aft_id' => $runAftId,
            'dedicated_server_id' => $server->ds_id,
            'server_id' => $server->id,
            'task' => GdaemonTask::TASK_SERVER_DELETE,
        ])->id;
    }

    /**
     * @param string|array $task task name
     * @param string $failMsg Failure message
     *
     * @throws RecordExistExceptions
     */
    private function workingTaskNotExistOrFail($serverId, $task, $failMsg = 'Task is already exists')
    {
        if (is_array($task)) {
            $taskQuery = GdaemonTask::whereIn(['task', $task])->where([['server_id', '=', $serverId]]);
        } else {
            $taskQuery = GdaemonTask::where([
                ['task', '=', $task],
                ['server_id', '=', $serverId]
            ]);
        }

        $taskExist = $taskQuery->whereIn('status', [
            GdaemonTask::STATUS_WAITING, 
            GdaemonTask::STATUS_WORKING
        ])->exists();

        if ($taskExist) {
            throw new RecordExistExceptions($failMsg);
        }
    }
}
