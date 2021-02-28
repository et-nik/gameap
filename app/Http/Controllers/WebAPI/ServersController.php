<?php

namespace Gameap\Http\Controllers\WebAPI;

use Exception;
use Gameap\Exceptions\Repositories\GdaemonTaskRepository\EmptyServerStartCommandException;
use Gameap\Exceptions\Repositories\GdaemonTaskRepository\GdaemonTaskRepositoryException;
use Gameap\Exceptions\Repositories\RecordExistExceptions;
use Gameap\Http\Controllers\AuthController;
use Gameap\Http\Requests\API\ServerConsoleCommandRequest;
use Gameap\Models\GdaemonTask;
use Gameap\Models\Server;
use Gameap\Repositories\GdaemonTaskRepository;
use Gameap\Repositories\ServerRepository;
use Gameap\Services\ServerControlService;
use Gameap\Services\ServerService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class ServersController extends AuthController
{
    /** @var ServerRepository */
    public $repository;

    /** @var GdaemonTaskRepository  */
    public $gdaemonTaskRepository;

    /** @var \Gameap\Services\ServerService  */
    public $serverService;

    /** @var \Gameap\Services\ServerControlService */
    public $serverControlService;

    public function __construct(
        ServerRepository $repository,
        GdaemonTaskRepository $gdaemonTaskRepository,
        ServerService $serverService,
        ServerControlService $serverControlService
    ) {
        parent::__construct();

        $this->repository            = $repository;
        $this->gdaemonTaskRepository = $gdaemonTaskRepository;
        $this->serverService         = $serverService;
        $this->serverControlService  = $serverControlService;
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function start(Server $server): array
    {
        $this->authorize('server-control', $server);
        $this->authorize('server-start', $server);

        $gdaemonTaskId = $this->serverControlService->start($server);

        return [
            'gdaemonTaskId' => $gdaemonTaskId,
        ];
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function stop(Server $server): array
    {
        $this->authorize('server-control', $server);
        $this->authorize('server-stop', $server);

        $gdaemonTaskId = $this->serverControlService->stop($server);

        return [
            'gdaemonTaskId' => $gdaemonTaskId,
        ];
    }

    /**
     * @throws \Gameap\Exceptions\Repositories\RecordExistExceptions
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function restart(Server $server): array
    {
        $this->authorize('server-control', $server);
        $this->authorize('server-restart', $server);

        $gdaemonTaskId = $this->serverControlService->restart($server);

        return [
            'gdaemonTaskId' => $gdaemonTaskId,
        ];
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Server $server): array
    {
        $this->authorize('server-control', $server);
        $this->authorize('server-update', $server);

        try {
            $gdaemonTaskId = $this->serverControlService->update($server);
        } catch (RecordExistExceptions $exception) {
            $gdaemonTaskId = $this->gdaemonTaskRepository->getFirstWaitingOrWorkingTaskId(
                $server->id,
                GdaemonTask::TASK_SERVER_UPDATE
            );

            if (!$gdaemonTaskId) {
                return $this->makeErrorResponse($exception->getMessage());
            }
        }

        return [
            'gdaemonTaskId' => $gdaemonTaskId,
        ];
    }

    /**
     * @throws \Gameap\Exceptions\Repositories\RecordExistExceptions
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function reinstall(Server $server): array
    {
        $this->authorize('server-control', $server);
        $this->authorize('server-update', $server);

        try {
            $deleteTaskId  = $this->gdaemonTaskRepository->addServerDelete($server);
            $gdaemonTaskId = $this->gdaemonTaskRepository->addServerUpdate($server, $deleteTaskId);
        } catch (RecordExistExceptions $exception) {
            return $this->makeErrorResponse($exception->getMessage());
        }

        return [
            'gdaemonTaskId' => $gdaemonTaskId,
        ];
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getStatus(Server $server): array
    {
        $this->authorize('server-control', $server);

        return [
            'processActive' => $server->processActive(),
        ];
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function query(Server $server): array
    {
        $this->authorize('server-control', $server);
        return $this->serverService->query($server);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function consoleLog(Server $server): array
    {
        $this->authorize('server-control', $server);
        $this->authorize('server-console-view', $server);

        return [
            'console' => $this->serverService->getConsoleLog($server),
        ];
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function sendCommand(ServerConsoleCommandRequest $request, Server $server): array
    {
        $this->authorize('server-control', $server);
        $this->authorize('server-console-send', $server);

        $command = $request->input('command');
        $this->serverService->sendConsoleCommand($server, $command);

        return ['message' => 'success'];
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        return $this->repository->search($query);
    }

    public function getList()
    {
        return QueryBuilder::for(Server::class)
            ->allowedFilters('ds_id')
            ->allowedAppends('full_path')
            ->get([
                'id',
                'uuid',
                'uuid_short',
                'enabled',
                'installed',
                'blocked',
                'name',
                'ds_id',
                'game_id',
                'game_mod_id',
                'server_ip',
                'server_port',
                'query_port',
                'rcon_port',
                'dir',
            ]);
    }

    /**
     * @param Exception $exception
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleException(\Throwable $exception)
    {
        if (Auth::user()->can('admin roles & permissions')) {
            $extraMessage = $this->getDocMessage($exception);
        } else {
            $extraMessage = (string)__('main.common_admin_error');
        }

        return $this->makeErrorResponse($exception->getMessage() . $extraMessage);
    }

    /**
     * @param Exception $exception
     * @return string
     */
    private function getDocMessage(\Throwable $exception)
    {
        $msg = '';

        if ($exception instanceof EmptyServerStartCommandException) {
            $msg = __('gdaemon_tasks.empty_server_start_command_doc');
        }

        return is_string($msg) ? $msg : '';
    }

    /**
     * @param $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    private function makeErrorResponse($message, $code = Response::HTTP_UNPROCESSABLE_ENTITY)
    {
        return response()->json([
            'message'   => $message,
            'http_code' => $code,
        ], $code);
    }
}
