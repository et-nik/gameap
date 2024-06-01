<?php

namespace Gameap\Http\Controllers\API;

use Gameap\Helpers\PermissionHelper;
use Gameap\Helpers\ServerPermissionHelper;
use Gameap\Http\Controllers\AuthController;
use Gameap\Models\GdaemonTask;
use Gameap\Models\User;
use Gameap\Repositories\GdaemonTaskRepository;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;

class GdaemonTasksController extends AuthController
{
    /**
     * The GdaemonTaskRepository instance.
     *
     * @var \Gameap\Repositories\GdaemonTaskRepository
     */
    public $repository;

    /** @var AuthFactory */
    protected $authFactory;

    /**
     * GdaemonTasksController constructor.
     * @param GdaemonTaskRepository $repository
     */
    public function __construct(GdaemonTaskRepository $repository, AuthFactory $auth)
    {
        parent::__construct();

        $this->repository = $repository;
        $this->authFactory = $auth;
    }

    /**
     * @param GdaemonTask $gdaemonTask
     * @return array
     */
    public function get(GdaemonTask $gdaemonTask)
    {
        /** @var User $currentUser */
        $currentUser = $this->authFactory->guard()->user();

        if (!$currentUser->can(PermissionHelper::ADMIN_PERMISSIONS)) {
            if (empty($gdaemonTask->server)) {
                abort(Response::HTTP_FORBIDDEN);
            }

            $this->authorize(ServerPermissionHelper::CONTROL_ABILITY, $gdaemonTask->server);
        }

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

    public function list()
    {
        return QueryBuilder::for(
            GdaemonTask::select('id','created_at', 'updated_at', 'dedicated_server_id', 'server_id', 'task', 'status', 'cmd')
        )
            ->allowedSorts(['created_at', 'id'])
            ->allowedFilters(['status', 'dedicated_server_id', 'server_id', 'task', 'status'])
            ->jsonPaginate();
    }

    /**
     * @param GdaemonTask $gdaemonTask
     * @return array
     */
    public function output(GdaemonTask $gdaemonTask)
    {
        return [
            'id'                    => $gdaemonTask->id,
            'dedicated_server_id'   => $gdaemonTask->dedicated_server_id,
            'server_id'             => $gdaemonTask->server_id,
            'task'                  => $gdaemonTask->task,
            'created_at'            => $gdaemonTask->created_at,
            'updated_at'            => $gdaemonTask->updated_at,
            'output'                => $gdaemonTask->output,
            'status'                => $gdaemonTask->status,
        ];
    }
}
