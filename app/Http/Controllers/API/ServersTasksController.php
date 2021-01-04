<?php

namespace Gameap\Http\Controllers\API;

use Carbon\Carbon;
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getList(Server $server)
    {
        $this->authorize('server-tasks', $server);

        $tasks = [];

        foreach ($this->repository->getTasks($server->id) as $task) {
            $task['execute_date'] = $this->convertDateToLocal($task['execute_date']);
            $tasks[] = $task;
        }

        return $tasks;
    }

    /**
     * @param ServerTaskCreateRequest $request
     * @return JsonResponse
     * @throws RepositoryValidationException|\Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ServerTaskCreateRequest $request)
    {
        $fields = $request->all();

        $server = Server::findOrFail($fields['server_id']);
        $this->authorize('server-tasks', $server);

        $this->commandAuthorize($fields['command'], $server);

        $fields['execute_date'] = $this->convertDateToUTC($fields['execute_date']);

        $serverTaskId = $this->repository->store($fields);

        return response()->json([
            'message'      => 'success',
            'serverTaskId' => $serverTaskId,
        ], Response::HTTP_CREATED);
    }

    /**
     * @param ServerTaskUpdateRequest $request
     * @param Server $server
     * @param ServerTask $serverTask
     * @return JsonResponse
     * @throws RepositoryValidationException|\Illuminate\Auth\Access\AuthorizationException
     * @noinspection PhpUnusedParameterInspection
     */
    public function update(ServerTaskUpdateRequest $request, Server $server, ServerTask $serverTask)
    {
        $fields = $request->all();

        $this->authorize('server-tasks', $server);
        $this->commandAuthorize($fields['command'], $server);

        $fields['execute_date'] = $this->convertDateToUTC($fields['execute_date']);

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

    private function convertDateToUTC(string $date): string
    {
        $convertedDate = Carbon::createFromFormat(Carbon::DEFAULT_TO_STRING_FORMAT, $date, config('timezone'));
        $convertedDate->setTimezone('UTC');

        return $convertedDate->toDateTimeString();
    }

    private function convertDateToLocal(string $date): string
    {
        $convertedDate = Carbon::createFromFormat(Carbon::DEFAULT_TO_STRING_FORMAT, $date, 'UTC');
        $convertedDate->setTimezone(config('timezone'));

        return $convertedDate->toDateTimeString();
    }
}
