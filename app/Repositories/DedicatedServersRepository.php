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
     * @param array $attributes
     */
    public function store(array $attributes)
    {
        $attributes['ip'] = array_filter($attributes['ip'], function($value) {
            return !empty($value);
        });

        DedicatedServer::create($attributes);
    }

    /**
     * @param array $fields
     * @param DedicatedServer        $dedicatedServer
     */
    public function update(DedicatedServer $dedicatedServer, array $attributes)
    {
        $attributes['ip'] = array_filter($attributes['ip'], function($value) {
            return !empty($value);
        });

        $dedicatedServer->update($attributes);
    }
}