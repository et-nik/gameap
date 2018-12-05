<?php

namespace Gameap\Http\Controllers\GdaemonAPI;

use Gameap\Models\DedicatedServer;
use Gameap\Models\GdaemonTask;
use Gameap\Repositories\GdaemonTaskRepository;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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

    /**
     * Update Gdaemon Task fields
     *
     * @param GdaemonTask $gdaemonTask
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(GdaemonTask $gdaemonTask)
    {
        $gdaemonTask->status = request()->status;
        $gdaemonTask->update();

        return response()->json(['message' => 'success'], Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param int $gdaemonTaskId
     * @return \Illuminate\Http\JsonResponse
     */
    public function output(Request $request, int $gdaemonTaskId)
    {
        if (GdaemonTask::where('id', $gdaemonTaskId)->count()) {
            $gdaemonTask = GdaemonTask::find($gdaemonTaskId);
            $output = DB::connection()->getPdo()->quote($request->output);
            $gdaemonTask->update(['output' => DB::raw("CONCAT(IFNULL(output,''), {$output})")]);
            $response = response()->json(['message' => 'success'], Response::HTTP_OK);
        } else {
            $response = response()->json(['message' => 'Task does not exist'], Response::HTTP_NOT_FOUND);
        }

        return $response;
    }
}