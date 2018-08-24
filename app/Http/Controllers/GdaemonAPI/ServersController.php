<?php

namespace Gameap\Http\Controllers\GdaemonAPI;

use Gameap\Models\Server;
use Gameap\Models\DedicatedServer;
use Gameap\Repositories\ServerRepository;

class ServersController extends Controller
{
    /**
     * @var ServerRepository
     */
    protected $repository;

    /**
     * ServersController constructor.
     * @param ServerRepository $serverRepository
     */
    public function __construct(ServerRepository $serverRepository)
    {
        $this->repository = $serverRepository;
    }

    /**
     * @param Server $server
     * @return Server
     */
    /*
    public function getServer(Server $server)
    {
        return $server;
    }
    /*

    /**
     * Return servers ids list
     *
     * @param int $dedicatedServerId
     * @return mixed
     */
    public function getIdList(int $dedicatedServerId)
    {
        return $this->repository->getServerIdsForDedicatedServer($dedicatedServerId);
    }
}