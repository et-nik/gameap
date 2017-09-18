<?php

namespace Gameap\Http\Controllers\Ajax;

use Gameap\Http\Controllers\Controller;
use Gameap\Repositories\DedicatedServersRepository;
use Gameap\Models\DedicatedServer;

class DedicatedServersController extends Controller
{
    /**
     * The DedicatedServersRepository instance.
     *
     * @var \Gameap\Repositories\DedicatedServersRepository
     */
    public $repository;

    /**
     * DedicatedServersController constructor.
     * @param DedicatedServersRepository $repository
     */
    public function __construct(DedicatedServersRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param integer  $id
     */
    public function getIpList(int $id)
    {
        return $this->repository->getIpList($id);
    }
}