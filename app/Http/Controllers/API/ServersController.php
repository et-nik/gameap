<?php

namespace Gameap\Http\Controllers\API;

use Gameap\Exceptions\Repositories\GdaemonTaskRepository\EmptyServerStartCommandException;
use Gameap\Exceptions\Repositories\GdaemonTaskRepository\GdaemonTaskRepositoryException;
use Gameap\Exceptions\Repositories\GdaemonTaskRepository\InvalidServerStartCommandException;
use Gameap\Exceptions\Repositories\RecordExistExceptions;
use Gameap\Http\Controllers\AuthController;
use Gameap\Repositories\ServerRepository;
use Gameap\Repositories\GdaemonTaskRepository;
use Gameap\Models\Server;
use Gameap\Models\GdaemonTask;
use Gameap\Services\ServerService;
use Gameap\Http\Requests\API\ServerConsoleCommandRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;
use Illuminate\Support\Facades\Auth;

class ServersController extends AuthController
{
    /**
     * The ServerRepository instance.
     *
     * @var \Gameap\Repositories\ServerRepository
     */
    public $repository;

    /**
     * The GdaemonTaskRepository instance.
     *
     * @var GdaemonTaskRepository
     */
    public $gdaemonTaskRepository;

    /**
     * @var \Gameap\Services\ServerService
     */
    public $serverService;

    /**
     * ServersController constructor.
     * @param ServerRepository $repository
     */
    public function __construct(
        ServerRepository $repository,
        GdaemonTaskRepository $gdaemonTaskRepository,
        ServerService $serverService
    ) {
        parent::__construct();

        $this->repository = $repository;
        $this->gdaemonTaskRepository = $gdaemonTaskRepository;
        $this->serverService = $serverService;
    }

    /**
     * @param Server $server
     *
     * @return array|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function start(Server $server)
    {
        $this->authorize('server-control', $server);

        try {
            $gdaemonTaskId = $this->gdaemonTaskRepository->addServerStart($server);
        } catch (GdaemonTaskRepositoryException $exception) {
            return $this->handleException($exception);
        } catch (RecordExistExceptions $exception) {
            $gdaemonTaskId = $this->gdaemonTaskRepository->getOneWorkingTaskId(
                $server->id,
                GdaemonTask::TASK_SERVER_START
            );

            if (!$gdaemonTaskId) {
                return $this->makeErrorResponse($exception->getMessage());
            }
        }

        return [
            'gdaemonTaskId' => $gdaemonTaskId
        ];
    }

    /**
     * @param Server $server
     *
     * @return array|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function stop(Server $server)
    {
        $this->authorize('server-control', $server);

        try {
            $gdaemonTaskId = $this->gdaemonTaskRepository->addServerStop($server);
        } catch (RecordExistExceptions $exception) {
            $gdaemonTaskId = $this->gdaemonTaskRepository->getOneWorkingTaskId(
                $server->id,
                GdaemonTask::TASK_SERVER_STOP
            );

            if (!$gdaemonTaskId) {
                return $this->makeErrorResponse($exception->getMessage());
            }
        }

        return [
            'gdaemonTaskId' => $gdaemonTaskId
        ];
    }

    /**
     * @param Server $server
     * @return array|\Illuminate\Http\JsonResponse
     *
     * @throws \Gameap\Exceptions\Repositories\RecordExistExceptions
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function restart(Server $server)
    {
        $this->authorize('server-control', $server);

        try {
            $gdaemonTaskId = $this->gdaemonTaskRepository->addServerRestart($server);
        } catch (GdaemonTaskRepositoryException $exception) {
            return $this->handleException($exception);
        } catch (RecordExistExceptions $exception) {
            $gdaemonTaskId = $this->gdaemonTaskRepository->getOneWorkingTaskId(
                $server->id,
                GdaemonTask::TASK_SERVER_RESTART
            );

            if (!$gdaemonTaskId) {
                return $this->makeErrorResponse($exception->getMessage());
            }
        }

        return [
            'gdaemonTaskId' => $gdaemonTaskId
        ];
    }

    /**
     * @param Server $server
     * @return array|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Server $server)
    {
        $this->authorize('server-control', $server);

        try {
            $gdaemonTaskId = $this->gdaemonTaskRepository->addServerUpdate($server);
        } catch (RecordExistExceptions $exception) {
            $gdaemonTaskId = $this->gdaemonTaskRepository->getOneWorkingTaskId(
                $server->id,
                GdaemonTask::TASK_SERVER_UPDATE
            );

            if (!$gdaemonTaskId) {
                return $this->makeErrorResponse($exception->getMessage());
            }
        }

        return [
            'gdaemonTaskId' => $gdaemonTaskId
        ];
    }

    /**
     * @param Server $server
     * @return array|\Illuminate\Http\JsonResponse
     *
     * @throws \Gameap\Exceptions\Repositories\RecordExistExceptions
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function reinstall(Server $server)
    {
        $this->authorize('server-control', $server);

        try {
            $deleteTaskId = $this->gdaemonTaskRepository->addServerDelete($server);
            $gdaemonTaskId = $this->gdaemonTaskRepository->addServerUpdate($server, $deleteTaskId);
        } catch (RecordExistExceptions $exception) {
            return $this->makeErrorResponse($exception->getMessage());
        }

        return [
            'gdaemonTaskId' => $gdaemonTaskId
        ];
    }

    /**
     * Get server status
     * @param Server $server
     * @return array
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getStatus(Server $server)
    {
        $this->authorize('server-control', $server);

        return [
            'processActive' => $server->processActive()
        ];
    }

    /**
     * @param Server $server
     * @return array
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function query(Server $server)
    {
        $this->authorize('server-control', $server);
        $query = $this->serverService->query($server);

        return $query;
    }

    /**
     * @param Server $server
     * @return array
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function consoleLog(Server $server)
    {
        $this->authorize('server-control', $server);
        return [
            'console' => $this->serverService->getConsoleLog($server)
        ];
    }

    /**
     * @param ServerConsoleCommandRequest $request
     * @param Server $server
     * @return array
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function sendCommand(ServerConsoleCommandRequest $request, Server $server)
    {
        $this->authorize('server-control', $server);

        $command = $request->input('command');
        $this->serverService->sendConsoleCommand($server, $command);

        return ['message' => 'success'];
    }

    /**
     * @param Request $request
     *
     * TODO: Create admin part and move this
     *
     * @return mixed
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        return $this->repository->search($query);
    }

    /**
     * @param Exception $exception
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleException(Exception $exception)
    {
        if (Auth::user()->can('admin roles & permissions')) {
            $extraMessage = $this->getDocMessage($exception);
        } else {
            $extraMessage = __('main.common_admin_error');
        }

        return $this->makeErrorResponse($exception->getMessage() . $extraMessage);
    }

    /**
     * @param Exception $exception
     * @return string
     */
    private function getDocMessage(Exception $exception)
    {
        $msg = '';

        if ($exception instanceof EmptyServerStartCommandException) {
            $msg = __('gdaemon_tasks.empty_server_start_command_doc');
        }

        return $msg;
    }

    /**
     * @param $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    private function makeErrorResponse($message, $code = Response::HTTP_UNPROCESSABLE_ENTITY)
    {
        return response()->json([
            'message' => $message,
            'http_code' => Response::HTTP_UNPROCESSABLE_ENTITY
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}