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
        $this->authorize('server-tasks', $server);

        return $this->repository->getTasks($server->id);
    }

    /**
     * @param ServerTaskCreateRequest $request
     * @return JsonResponse
     * @throws RepositoryValidationException
     */
    public function store(ServerTaskCreateRequest $request)
    {
        $fields = $request->all();

        $server = Server::findOrFail($fields['server_id']);
        $this->authorize('server-tasks', $server);

        $this->commandAuthorize($fields['command'], $server);

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
        $fields = $request->all();

        $server = Server::findOrFail($fields['server_id']);

        $this->authorize('server-tasks', $server);
        $this->commandAuthorize($fields['command'], $server);

        $this->repository->update($serverTask->id, $fields);

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
        $this->authorize('server-tasks', $server);

        $serverTask->delete();
        return response()->json(['message' => 'success'], Response::HTTP_OK);
    }

    /**
     * @param string $command
     * @param Server $server
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    private function commandAuthorize(string $command, Server $server): void
    {
        switch ($command) {
            case 'start':
                $this->authorize('server-start', $server);
                break;

            case 'stop':
                $this->authorize('server-stop', $server);
                break;

            case 'restart':
                $this->authorize('server-restart', $server);
                break;

            case 'update':
            case 'reinstall':
                $this->authorize('server-update', $server);
                break;
        }
    }
}