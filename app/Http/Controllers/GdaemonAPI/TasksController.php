<?php

namespace Gameap\Http\Controllers\GdaemonAPI;

use Gameap\Models\DedicatedServer;
use Gameap\Models\GdaemonTask;
use Gameap\Repositories\GdaemonTaskRepository;
use Spatie\QueryBuilder\QueryBuilder;

class TasksController extends Controller
{
    /**
     * The GdaemonTasksRepository instance.
     *
     * @var \Gameap\Repositories\GdaemonTaskRepository
     */
    protected $repository;

    /**
     * Create a new GdaemonTasksController instance.
     *
     * @param  \Gameap\Repositories\GdaemonTaskRepository $repository
     */
    public function __construct(GdaemonTaskRepository $repository)
    {
        parent::__construct();
        
        $this->repository = $repository;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|QueryBuilder[]
     */
    public function index(DedicatedServer $dedicatedServer)
    {
        return QueryBuilder::for(GdaemonTask::where('dedicated_server_id', $dedicatedServer->id))
            ->allowedFilters('status')
            ->allowedAppends('status_num')
            ->get();
    }
}