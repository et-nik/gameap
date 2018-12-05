<?php

namespace Gameap\Repositories;

use Gameap\Models\Server;
use Illuminate\Support\Str;
use Gameap\Http\Requests\ServerRequest;

class ServerRepository
{
    protected $model;

    protected $gdaemonTaskRepository;

    public function __construct(Server $server, GdaemonTaskRepository $gdaemonTaskRepository)
    {
        $this->model = $server;
        $this->gdaemonTaskRepository = $gdaemonTaskRepository;
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
        $attributes['uuid'] = Str::orderedUuid()->toString();
        $attributes['uuid_short'] = Str::substr($attributes['uuid'], 0, 8);

        $addInstallTask = false;
        if (isset($attributes['install'])) {
            $attributes['installed'] = ! $attributes['install'];
            $addInstallTask = true;

            unset($attributes['install']);
        }

        $server = Server::create($attributes);

        if ($addInstallTask) {
            $this->gdaemonTaskRepository->addServerUpdate($server);
        }
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