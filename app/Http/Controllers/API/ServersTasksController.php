<?php

namespace Gameap\Http\Controllers\API;

use Gameap\Http\Controllers\AuthController;
use Gameap\Http\Requests\API\ServerTaskCreateRequest;
use Gameap\Models\Server;
use Gameap\Models\ServerTask;
use Gameap\Repositories\ServersTasksRepository;

class ServersTasksController extends AuthController
{
    /** @var ServersTasksRepository */
    protected $repository;

    public function __construct(ServersTasksRepository $serversTasksRepository)
    {
        $this->repository = $serversTasksRepository;
    }

    /**
     * @param Server $server
     * @return ServerTask[]
     */
    public function getList(Server $server)
    {
        return $this->repository->getTask($server->id);
    }

    /**
     * @param ServerTaskCreateRequest $request
     * @return string[]
     */
    public function store(ServerTaskCreateRequest $request)
    {
        $serverTaskId = $this->repository->store($request->all());

        return [
            'serverTaskId' => $serverTaskId
        ];
    }

    /**
     * @param ServerTaskCreateRequest $request
     * @param ServerTask $serverTask
     * @return string[]
     */
    public function update(ServerTaskCreateRequest $request, Server $server, ServerTask $serverTask)
    {
        $this->repository->update($serverTask->id, $request->all());

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