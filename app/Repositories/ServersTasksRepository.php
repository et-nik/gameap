<?php

namespace Gameap\Repositories;

use Carbon\CarbonInterval;
use Gameap\Exceptions\Repositories\RepositoryValidationException;
use Gameap\Models\ServerTask;

class ServersTasksRepository
{
    const MIN_PERIOD_IN_SECONDS = 600;

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
    public function getTasks(int $serverId): array
    {
        $tasks = [];

        /** @var ServerTask $task */
        foreach (ServerTask::where('server_id', $serverId)->get() as $task) {
            $tasks[] = $this->convertModelToArray($task);
        }

        return $tasks;
    }

    /**
     * @param int $taskId
     * @return array
     */
    public function get(int $taskId): array
    {
        return $this->convertModelToArray(ServerTask::find($taskId));
    }

    /**
     * @param array $task
     * @return int
     * @throws RepositoryValidationException
     */
    public function store(array $task): int
    {
        $this->validate($task);
        $convertedTask = $this->convert($task);

        $serverTask = ServerTask::create($convertedTask);

        return $serverTask->id;
    }

    /**
     * @param int $taskId
     * @param array $task
     * @throws RepositoryValidationException
     */
    public function update(int $taskId, array $task)
    {
        $this->validate($task);
        $convertedTask = $this->convert($task);

        ServerTask::where('id', $taskId)->update($convertedTask);
    }

    /**
     * @param array $task
     * @return array
     * @throws RepositoryValidationException
     */
    private function convert(array $task) {

        if ($task['repeat'] != 1) {
            if (empty($task['repeat_period'])) {
                throw new RepositoryValidationException(__('servers_tasks.errors.empty_period'));
            }

            $task['repeat_period'] = CarbonInterval::fromString($task['repeat_period'])
                ->locale('en')
                ->cascade()
                ->totalSeconds;

            if ($task['repeat_period'] < self::MIN_PERIOD_IN_SECONDS) {
                throw new RepositoryValidationException(__('servers_tasks.errors.minimum_period'));
            }
        } else {
            $task['repeat_period'] = 0;
        }

        return $task;
    }

    /**
     * @param array $task
     * @throws RepositoryValidationException
     */
    private function validate(array $task) {
        if (empty($task) || empty($task['command'])) {
            throw new RepositoryValidationException(__('servers_tasks.errors.empty_command'));
        }
    }

    /**
     * @param ServerTask $task
     * @return array
     */
    private function convertModelToArray(ServerTask $task)
    {
        return [
            'id'            => $task->id,
            'command'       => $task->command,
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
}
