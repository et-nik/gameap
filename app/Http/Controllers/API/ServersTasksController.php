<?php

namespace Gameap\Http\Controllers\API;

use Gameap\Http\Controllers\AuthController;
use Gameap\Http\Requests\API\ServerTaskCreateRequest;
use Gameap\Models\Server;
use Gameap\Models\ServerTask;

class ServersTasksController extends AuthController
{
    /**
     * @param Server $server
     * @return ServerTask[]
     */
    public function getList(Server $server)
    {
        return $server->tasks;
    }

    /**
     * @param ServerTaskCreateRequest $request
     * @return string[]
     */
    public function store(ServerTaskCreateRequest $request)
    {
        $serverTask = ServerTask::create($request->all());

        return [
            'serverTaskId' => $serverTask->id
        ];
    }

    /**
     * @param ServerTaskCreateRequest $request
     * @param ServerTask $serverTask
     * @return string[]
     */
    public function update(ServerTaskCreateRequest $request, Server $server, ServerTask $serverTask)
    {
        $serverTask->update($request->all());
        return ['success'];
    }

    /**
     * @param Server $server
     * @param ServerTask $serverTask
     * @return string[]
     * @throws \Exception
     */
    public function destroy(Server $server, ServerTask $serverTask)
    {
        $serverTask->delete();
        return ['success'];
    }
}