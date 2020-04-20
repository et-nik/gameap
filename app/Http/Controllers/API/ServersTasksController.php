<?php

namespace Gameap\Http\Controllers\API;

use Gameap\Exceptions\Repositories\RepositoryValidationException;
use Gameap\Http\Controllers\AuthController;
use Gameap\Http\Requests\API\ServerTaskCreateRequest;
use Gameap\Http\Requests\API\ServerTaskUpdateRequest;
use Gameap\Models\Server;
use Gameap\Models\ServerTask;
use Gameap\Repositories\ServersTasksRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

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
     * @return array
     */
    public function getList(Server $server)
    {
        return $this->repository->getTasks($server->id);
    }

    /**
     * @param ServerTaskCreateRequest $request
     * @return JsonResponse
     * @throws RepositoryValidationException
     */
    public function store(ServerTaskCreateRequest $request)
    {
        $serverTaskId = $this->repository->store($request->all());

        return response()->json([
            'message' => 'success',
            'serverTaskId' => $serverTaskId,
        ], Response::HTTP_CREATED);
    }

    /**
     * @param ServerTaskUpdateRequest $request
     * @param Server $server
     * @param ServerTask $serverTask
     * @return JsonResponse
     * @throws RepositoryValidationException
     * @noinspection PhpUnusedParameterInspection
     */
    public function update(ServerTaskUpdateRequest $request, Server $server, ServerTask $serverTask)
    {
        $this->repository->update($serverTask->id, $request->all());

        return response()->json(['message' => 'success'], Response::HTTP_OK);
    }

    /**
     * @param Server $server
     * @param ServerTask $serverTask
     * @return JsonResponse
     * @throws \Exception
     * @noinspection PhpUnusedParameterInspection
     */
    public function destroy(Server $server, ServerTask $serverTask)
    {
        $serverTask->delete();
        return response()->json(['message' => 'success'], Response::HTTP_OK);
    }
}