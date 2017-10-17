<?php

namespace Gameap\Http\Controllers\Api;

use Gameap\Http\Controllers\AuthController;
use Gameap\Repositories\GdaemonTaskRepository;
use Gameap\Models\GdaemonTask;

class GdaemonTasksController extends AuthController
{
    /**
     * The GdaemonTaskRepository instance.
     *
     * @var \Gameap\Repositories\GdaemonTaskRepository
     */
    public $repository;

    /**
     * GdaemonTasksController constructor.
     * @param GdaemonTaskRepository $repository
     */
    public function __construct(GdaemonTaskRepository $repository)
    {
        parent::__construct();

        $this->repository = $repository;
    }

    /**
     * @param GdaemonTask $gdaemonTask
     */
    public function get(GdaemonTask $gdaemonTask)
    {
        return [
            'id' => $gdaemonTask->id,
            'run_aft_id' => $gdaemonTask->id,
            'created_at' => $gdaemonTask->created_at->toDateTimeString(),
            'updated_at' => $gdaemonTask->updated_at->toDateTimeString(),
            'server_id' => $gdaemonTask->server_id,
            'task' => $gdaemonTask->task,
            'status' => $gdaemonTask->status,
        ];
    }
}