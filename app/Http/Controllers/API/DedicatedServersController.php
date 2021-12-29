<?php

namespace Gameap\Http\Controllers\API;

use Gameap\Http\Controllers\AuthController;
use Gameap\Repositories\NodeRepository;

class DedicatedServersController extends AuthController
{
    /**
     * The DedicatedServersRepository instance.
     *
     * @var \Gameap\Repositories\NodeRepository
     */
    public $repository;

    /**
     * DedicatedServersController constructor.
     * @param NodeRepository $repository
     */
    public function __construct(NodeRepository $repository)
    {
        parent::__construct();

        $this->repository = $repository;
    }

    /**
     * @param int $id
     * @return array
     */
    public function getIpList(int $id)
    {
        return $this->repository->getIpList($id);
    }

    /**
     * @param int $id
     * @return array
     */
    public function getBusyPorts(int $id)
    {
        return $this->repository->getBusyPorts($id);
    }
}
