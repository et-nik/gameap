<?php

namespace Gameap\Http\Controllers\GdaemonAPI;

use Gameap\Models\DedicatedServer;
use Gameap\Models\GdaemonTask;
use Gameap\Repositories\GdaemonTaskRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;

class TasksController extends Controller
{
    /**
     * The GdaemonTasksRepository instance.
     *
     * @var \Gameap\Repositories\GdaemonTaskRepository
     */
    protected $repository;

    public function __construct(GdaemonTaskRepository $repository)
    {
        parent::__construct();

        $this->repository = $repository;
    }

    /**
     * @return Collection|QueryBuilder[]
     */
    public function index(DedicatedServer $dedicatedServer)
    {
        return QueryBuilder::for(GdaemonTask::where('dedicated_server_id', $dedicatedServer->id))
            ->allowedFilters('status')
            ->allowedAppends('status_num')
            ->get();
    }

    public function update(GdaemonTask $gdaemonTask): JsonResponse
    {
        $status = request()->status;

        if (is_null($status)) {
            return response()->json(['message' => 'Empty status'], Response::HTTP_BAD_REQUEST);
        }

        if (!in_array($status, GdaemonTask::NUM_STATUSES, true)) {
            return response()->json(['message' => 'Invalid status'], Response::HTTP_BAD_REQUEST);
        }

        $gdaemonTask->status = is_int($status)
            ? array_flip(GdaemonTask::NUM_STATUSES)[$status]
            : $status;

        $gdaemonTask->update();

        return response()->json(['message' => 'success'], Response::HTTP_OK);
    }

    public function output(Request $request, int $gdaemonTaskId): JsonResponse
    {
        if (GdaemonTask::where('id', $gdaemonTaskId)->exists()) {

            $gdaemonTask = GdaemonTask::findOrFail($gdaemonTaskId);
            $this->repository->concatOutput($gdaemonTask, $request->output);

            $response = response()->json(['message' => 'success'], Response::HTTP_OK);
        } else {
            $response = response()->json(['message' => 'Task does not exist'], Response::HTTP_NOT_FOUND);
        }

        return $response;
    }
}
