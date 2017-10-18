<?php

namespace Gameap\Repositories;

use Gameap\Models\DedicatedServer;
use Gameap\Http\Requests\DedicatedServerRequest;

class DedicatedServersRepository
{
    protected $model;

    public function __construct(DedicatedServer $dedicatedServer)
    {
        $this->model = $dedicatedServer;
    }

    public function getAll($perPage = 20)
    {
        return DedicatedServer::orderBy('id')->withCount('servers')->paginate($perPage);
    }

    /**
     * @param int $id
     * @return array
     */
    public function getIpList(int $id)
    {
        return $this->model->select('ip')
            ->where('id', '=', $id)
            ->first()
            ->ip;
    }

    /**
     * @param DedicatedServerRequest $dedicatedServerRequest
     */
    public function store(DedicatedServerRequest $dedicatedServerRequest)
    {
        $dedicatedServer = DedicatedServer::create($dedicatedServerRequest->all());
    }

    /**
     * @param DedicatedServerRequest $dedicatedServerRequest
     * @param DedicatedServer        $dedicatedServer
     */
    public function update(DedicatedServerRequest $dedicatedServerRequest, DedicatedServer $dedicatedServer)
    {
        $dedicatedServer->update($dedicatedServerRequest->all());
    }
}