<?php

namespace Gameap\Http\Controllers\API;

use Gameap\Http\Controllers\AuthController;
use Gameap\Http\Requests\API\Admin\SaveNodeRequest;
use Gameap\Repositories\NodeRepository;
use Gameap\Models\DedicatedServer;

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

    public function list()
    {
        $collection = $this->repository->getAll();

        return $collection->map(function ($item) {
            return $item->only([
                'id',
                'enabled',
                'name',
                'os',
                'location',
                'provider',
                'ip',
            ]);
        });
    }

    public function get(int $id)
    {
        return $this->repository->findById($id);
    }

    public function save(SaveNodeRequest $request)
    {
        if ($request->id()) {
            $node = $this->repository->findById($request->id);
            $this->repository->update($node, $request->all());
        } else {
            $node = $this->repository->store($request->all());
        }

        return ['message' => 'success', 'result' => $node->id];
    }

    public function destroy(int $id)
    {
        $node = $this->repository->findById($id);
        if (count($node->servers) > 0) {
            return ['message' => 'error', 'error' => __('dedicated_servers.delete_has_servers_error_msg')];
        }

        $this->repository->destroy($node);

        return ['message' => 'success'];
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
