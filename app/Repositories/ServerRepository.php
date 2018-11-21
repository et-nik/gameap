<?php

namespace Gameap\Repositories;

use Gameap\Models\Server;
use Gameap\Http\Requests\ServerRequest;

class ServerRepository
{
    protected $model;

    public function __construct(Server $server)
    {
        $this->model = $server;
    }

    public function getAll($perPage = 20)
    {
        $servers = Server::orderBy('id')->with('game')->paginate($perPage);

        return $servers;
    }

    /**
     * Store server
     * 
     * @param array $attributes
     */
    public function store(array $attributes)
    {
        Server::create($attributes);
    }

    /**
     * Get Servers list for Dedicated server
     *
     * @param int $dedicatedServerId
     */
    public function getServersListForDedicatedServer(int $dedicatedServerId)
    {
        return $this->model->select('*')
            ->where('ds_id', '=', $dedicatedServerId)
            ->get();
    }

    /**
     * Get Servers id list for Dedicated server
     *
     * @param int $dedicatedServerId
     */
    public function getServerIdsForDedicatedServer(int $dedicatedServerId)
    {
        return $this->model->select('id')
            ->where('ds_id', '=', $dedicatedServerId)
            ->get();
    }
}