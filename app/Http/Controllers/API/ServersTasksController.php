<?php

namespace Gameap\Http\Controllers\API;

use Gameap\Exceptions\Repositories\RepositoryValidationException;
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
        parent::__construct();
        $this->repository = $serversTasksRepository;
    }

    /**
     * @param Server $server
     * @return ServerTask[]
     */
    public function getList(Server $server)
    {
        return $this->repository->getTasks($server->id);
    }

    /**
     * @param ServerTaskCreateRequest $request
     * @return string[]
     * @throws RepositoryValidationException
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
     * @param Server $server
     * @param ServerTask $serverTask
     * @return string[]
     * @throws RepositoryValidationException
     * @noinspection PhpUnusedParameterInspection
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
     * @noinspection PhpUnusedParameterInspection
     */
    public function destroy(Server $server, ServerTask $serverTask)
    {
        $serverTask->delete();
        return ['success'];
    }
}