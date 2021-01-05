<?php

namespace Gameap\Http\Controllers\GdaemonAPI;

use Gameap\Http\Requests\GdaemonAPI\ServerTaskFailRequest;
use Gameap\Http\Requests\GdaemonAPI\ServerTaskUpdateRequest;
use Gameap\Models\DedicatedServer;
use Gameap\Models\ServerTask;
use Gameap\Models\ServerTaskFail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ServersTasksController extends Controller
{
    /**
     * @param DedicatedServer $dedicatedServer
     * @return mixed
     */
    public function getList(DedicatedServer $dedicatedServer)
    {
        return ServerTask::whereIn('server_id', function ($query) use ($dedicatedServer): void {
            $query->select('id')
                ->from('servers')
                ->where('ds_id', $dedicatedServer->id);
        })->get();
    }

    /**
     * @param int $serverTaskId
     * @return ServerTask
     */
    public function get(int $serverTaskId)
    {
        return ServerTask::find($serverTaskId);
    }

    /**
     * @param ServerTaskUpdateRequest $request
     * @param ServerTask $serverTask
     * @return JsonResponse
     */
    public function update(ServerTaskUpdateRequest $request, ServerTask $serverTask)
    {
        $serverTask->counter++;

        return $serverTask->update($request->all())
            ? response()->json(['message' => 'success'], Response::HTTP_OK)
            : response()->json(['message' => 'fail'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @param ServerTaskFailRequest $request
     * @param ServerTask $serverTask
     * @return JsonResponse
     */
    public function fail(ServerTaskFailRequest $request, ServerTask $serverTask)
    {
        $serverTaskFail = new ServerTaskFail();

        $serverTaskFail->server_task_id = $serverTask->id;
        $serverTaskFail->output         = $request->get('output');

        return $serverTaskFail->save()
            ? response()->json(['message' => 'success'], Response::HTTP_OK)
            : response()->json(['message' => 'fail'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
