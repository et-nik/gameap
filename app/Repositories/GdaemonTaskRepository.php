<?php

namespace Gameap\Repositories;

use Gameap\Exceptions\Repositories\GdaemonTaskRepositoryException;
use Gameap\Models\Server;
use Gameap\Models\GdaemonTask;
use Gameap\Models\DedicatedServer;
use Gameap\Exceptions\Repositories\RecordExistExceptions;
use Illuminate\Support\Facades\DB;
use PDO;

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
        $this->workingTaskNotExistOrFail($server, GdaemonTask::TASK_SERVER_START, 'Server start task is already exists');
        
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
        $this->workingTaskNotExistOrFail($server, GdaemonTask::TASK_SERVER_STOP, 'Server stop task is already exists');

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
        $this->workingTaskNotExistOrFail($server, GdaemonTask::TASK_SERVER_RESTART, 'Server restart task is already exists');
        
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
        $this->workingTaskNotExistOrFail($server, GdaemonTask::TASK_SERVER_UPDATE, 'Server update/install task is already exists');
        
        return GdaemonTask::create([
            'run_aft_id' => $runAftId,
            'dedicated_server_id' => $server->ds_id,
            'server_id' => $server->id,
            'task' => GdaemonTask::TASK_SERVER_UPDATE,
        ])->id;
    }

    /**
     * Remove server files
     *
     * @param Server $server
     * @param int    $runAftId
     * @return int Gdaemon Task ID
     * @throws RecordExistExceptions
     */
    public function addServerDelete(Server $server, int $runAftId = 0)
    {
        $this->workingTaskNotExistOrFail($server, GdaemonTask::TASK_SERVER_DELETE, 'Server delete task is already exists');
        
        return GdaemonTask::create([
            'run_aft_id' => $runAftId,
            'dedicated_server_id' => $server->ds_id,
            'server_id' => $server->id,
            'task' => GdaemonTask::TASK_SERVER_DELETE,
        ])->id;
    }

    /**
     * @param GdaemonTask $gdaemonTask
     * @param string $output
     */
    public function concatOutput(GdaemonTask $gdaemonTask, string $output)
    {
        if (empty($output)) {
            return;
        }

        $qoutedOutput = DB::connection()->getPdo()->quote($output);

        $dbDriver = DB::connection()->getPDO()->getAttribute(PDO::ATTR_DRIVER_NAME);

        if ($dbDriver == 'mysql') {
            $gdaemonTask->update(['output' => DB::raw("CONCAT(IFNULL(output,''), {$qoutedOutput})")]);
        } else if ($dbDriver == 'sqlite' || $dbDriver == 'pgsql') {
            $gdaemonTask->update(['output' => DB::raw("COALESCE(output, '') || {$qoutedOutput}")]);
        } else {
            $gdaemonTask->update(['output' => $gdaemonTask->output . $output]);
        }
    }

    /**
     * @param GdaemonTask $gdaemonTask
     * @throws GdaemonTaskRepositoryException
     */
    public function cancel(GdaemonTask $gdaemonTask)
    {
        if ($gdaemonTask->status != GdaemonTask::STATUS_WAITING) {
            throw new GdaemonTaskRepositoryException(__('gdaemon_tasks.cancel_fail_cannot_be_canceled'));
        }

        $gdaemonTask->status = GdaemonTask::STATUS_CANCELED;
        $gdaemonTask->save();
    }

    /**
     * @param Server $server
     * @param string|array $task task name
     * @param string $failMsg Failure message
     *
     * @throws RecordExistExceptions
     */
    private function workingTaskNotExistOrFail(Server $server, $task, $failMsg = 'Task is already exists')
    {
        if (is_array($task)) {
            $taskQuery = GdaemonTask::whereIn(['task', $task])->where([['server_id', '=', $server->id]]);
        } else {
            $taskQuery = GdaemonTask::where([
                ['task', '=', $task],
                ['server_id', '=', $server->id],
                ['dedicated_server_id', '=', $server->ds_id]
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
