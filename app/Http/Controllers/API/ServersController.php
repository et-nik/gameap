<?php

namespace Gameap\Http\Controllers\API;

use Gameap\Http\Controllers\AuthController;
use Gameap\Repositories\ServerRepository;
use Gameap\Repositories\GdaemonTaskRepository;
use Gameap\Models\Server;
use Gameap\Services\ServerService;
use Gameap\Http\Requests\API\ServerConsoleCommandRequest;
use Illuminate\Http\Request;

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
     * @return array
     *
     * @throws \Gameap\Exceptions\Repositories\RecordExistExceptions
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function start(Server $server)
    {
        $this->authorize('server-control', $server);

        return [
            'gdaemonTaskId' => $this->gdaemonTaskRepository->addServerStart($server)
        ];
    }

    /**
     * @param Server $server
     *
     * @return array
     *
     * @throws \Gameap\Exceptions\Repositories\RecordExistExceptions
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function stop(Server $server)
    {
        $this->authorize('server-control', $server);

        return [
            'gdaemonTaskId' => $this->gdaemonTaskRepository->addServerStop($server)
        ];
    }

    /**
     * @param Server $server
     * @return array
     *
     * @throws \Gameap\Exceptions\Repositories\RecordExistExceptions
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function restart(Server $server)
    {
        $this->authorize('server-control', $server);

        return [
            'gdaemonTaskId' => $this->gdaemonTaskRepository->addServerRestart($server)
        ];
    }

    /**
     * @param Server $server
     * @return array
     *
     * @throws \Gameap\Exceptions\Repositories\RecordExistExceptions
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Server $server)
    {
        $this->authorize('server-control', $server);

        return [
            'gdaemonTaskId' => $this->gdaemonTaskRepository->addServerUpdate($server)
        ];
    }

    /**
     * @param Server $server
     * @return array
     *
     * @throws \Gameap\Exceptions\Repositories\RecordExistExceptions
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function reinstall(Server $server)
    {
        $this->authorize('server-control', $server);

        $deleteTaskId = $this->gdaemonTaskRepository->addServerDelete($server);

        return [
            'gdaemonTaskId' => $this->gdaemonTaskRepository->addServerUpdate($server, $deleteTaskId)
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
}