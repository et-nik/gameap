<?php

namespace Gameap\Repositories;

use Gameap\Models\DedicatedServer;

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
}