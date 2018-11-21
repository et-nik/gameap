<?php

namespace Gameap\Http\Controllers\API;

use Gameap\Http\Controllers\AuthController;
use Gameap\Repositories\ServerRepository;
use Gameap\Repositories\GdaemonTaskRepository;
use Gameap\Models\Server;

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
     * ServersController constructor.
     * @param ServerRepository $repository
     */
    public function __construct(ServerRepository $repository, GdaemonTaskRepository $gdaemonTaskRepository)
    {
        parent::__construct();

        $this->repository = $repository;
        $this->gdaemonTaskRepository = $gdaemonTaskRepository;
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
     */
    public function restart(Server $server)
    {
        return [
            'gdaemonTaskId' => $this->gdaemonTaskRepository->addServerRestart($server)
        ];
    }

    /**
     * @param Server $server
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
     */
    public function getStatus(Server $server)
    {
        return [
            'processActive' => $server->processActive()
        ];
    }
}