<?php

namespace Gameap\Http\Controllers\API;

use Gameap\Http\Controllers\AuthController;
use Gameap\Models\GdaemonTask;
use Gameap\Repositories\GdaemonTaskRepository;

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
     * @return array
     */
    public function get(GdaemonTask $gdaemonTask)
    {
        return [
            'id'         => $gdaemonTask->id,
            'run_aft_id' => $gdaemonTask->id,
            'created_at' => $gdaemonTask->created_at->toDateTimeString(),
            'updated_at' => $gdaemonTask->updated_at->toDateTimeString(),
            'server_id'  => $gdaemonTask->server_id,
            'task'       => $gdaemonTask->task,
            'status'     => $gdaemonTask->status,
        ];
    }

    /**
     * @param GdaemonTask $gdaemonTask
     * @return array
     */
    public function output(GdaemonTask $gdaemonTask)
    {
        return [
            'id'     => $gdaemonTask->id,
            'output' => $gdaemonTask->output,
            'status' => $gdaemonTask->status,
        ];
    }
}
