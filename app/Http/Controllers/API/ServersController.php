<?php

namespace Gameap\Http\Controllers\API;

use Gameap\Http\Controllers\AuthController;
use Gameap\Repositories\ServerRepository;
use Gameap\Repositories\GdaemonTaskRepository;
use Gameap\Models\Server;
use Gameap\Services\ServerService;
use Gameap\Http\Requests\API\ServerConsoleCommandRequest;

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
     */
    public function start(Server $server)
    {
        return [
            'gdaemonTaskId' => $this->gdaemonTaskRepository->addServerStart($server)
        ];
    }

    /**
     * @param Server $server
     *
     * @return array
     */
    public function stop(Server $server)
    {
        return [
            'gdaemonTaskId' => $this->gdaemonTaskRepository->addServerStop($server)
        ];
    }

    /**
     * @param Server $server
     * @return array
     */
    public function restart(Server $server)
    {
        return [
            'gdaemonTaskId' => $this->gdaemonTaskRepository->addServerRestart($server)
        ];
    }

    /**
     * @param Server $server
     * @return array
     */
    public function update(Server $server)
    {
        return [
            'gdaemonTaskId' => $this->gdaemonTaskRepository->addServerUpdate($server)
        ];
    }

    /**
     * Get server status
     * @param Server $server
     * @return array
     */
    public function getStatus(Server $server)
    {
        return [
            'processActive' => $server->processActive()
        ];
    }

    /**
     * @param Server $server
     * @return array
     */
    public function query(Server $server)
    {
        $query = $this->serverService->query($server);

        return $query;
    }

    /**
     * @param Server $server
     * @return array
     */
    public function consoleLog(Server $server)
    {
        return [
            'console' => $this->serverService->getConsoleLog($server)
        ];
    }

    /**
     * @param Server $server
     * @return array
     */
    public function sendCommand(ServerConsoleCommandRequest $request, Server $server)
    {
        $command = $request->input('command');
        $this->serverService->sendConsoleCommand($server, $command);

        return ['message' => 'success'];
    }
}