<?php

namespace Gameap\Repositories;

use Carbon\CarbonInterval;
use Gameap\Exceptions\GameapException;
use Gameap\Models\ServerTask;

class ServersTasksRepository
{
    /** @var ServerTask */
    protected $model;

    public function __construct(ServerTask $serverTask)
    {
        $this->model = $serverTask;
    }

    /**
     * @param int $serverId
     * @return array
     */
    public function getTask(int $serverId): array
    {
        $tasks = [];

        /** @var ServerTask $task */
        foreach (ServerTask::where('server_id', $serverId)->get() as $task) {
            $tasks[] = [
                'id'            => $task->id,
                'task'          => $task->task,
                'server_id'     => $task->server_id,
                'repeat'        => $task->repeat,
                'repeat_period' => CarbonInterval::seconds($task->repeat_period)
                    ->locale('en')
                    ->cascade()
                    ->forHumans(),
                'execute_date'  => $task->execute_date,
                'payload'       => $task->payload,
                'created_at'    => $task->created_at,
                'updated_at'    => $task->updated_at
            ];
        }

        return $tasks;
    }

    /**
     * @param array $task
     * @return int
     * @throws GameapException
     */
    public function store(array $task): int
    {
        if (!empty($task)) {
            throw new GameapException('Empty task');
        }

        if (empty($task['repeat_period'])) {
            throw new GameapException('Empty repeat period');
        }

        $serverTask = ServerTask::create($this->convert($task));

        return $serverTask->id;
    }

    /**
     * @param array $task
     */
    public function update(int $taskId, array $task)
    {
        ServerTask::where('id', $taskId)->update($this->convert($task));
    }

    /**
     * @param array $task
     * @return array
     */
    private function convert(array $task) {
        $task['repeat_period'] = CarbonInterval::fromString($task['repeat_period'])
            ->locale('en')
            ->cascade()
            ->totalSeconds;

        return $task;
    }
}