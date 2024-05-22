<?php

namespace Gameap\Http\Controllers\API;

use Gameap\Http\Controllers\AuthController;
use Gameap\Http\Requests\API\Admin\StoreNodeRequest;
use Gameap\Http\Requests\API\Admin\UpdateNodeRequest;
use Gameap\Repositories\NodeRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    public function update($id, UpdateNodeRequest $request)
    {
        $attributes = $request->all();

        $node = $this->repository->findById($id);

        if (!empty($attributes['gdaemon_server_cert'])) {
            $cert = $attributes['gdaemon_server_cert'];
            if (!$cert) {
                return response()->json(['message' => 'Invalid certificate'], 400);
            }

            $path = 'certs/server/'.Str::Random(32);
            Storage::disk('local')->put($path, $cert);

            $certificateFile = Storage::disk('local')
                ->getDriver()
                ->getAdapter()
                ->applyPathPrefix($node->gdaemon_server_cert);

            if (file_exists($certificateFile)) {
                unlink($certificateFile);
            }

            $attributes['gdaemon_server_cert'] = $path;
        } else {
            $attributes['gdaemon_server_cert'] = $node->gdaemon_server_cert;
        }

        $this->repository->update($node, $attributes);

        return ['message' => 'success'];
    }

    public function setup()
    {
        // Add auto setup token
        $autoSetupToken = env('DAEMON_SETUP_TOKEN');

        if (empty($autoSetupToken)) {
            $autoSetupToken = Str::random(24);
            Cache::put('gdaemonAutoSetupToken', $autoSetupToken, 300);
        }

        return [
            'link' => route('gdaemon.setup', ['token' => $autoSetupToken]),
            'token' => $autoSetupToken,
            'host' => request()->getSchemeAndHttpHost(),
        ];
    }

    public function store(StoreNodeRequest $request)
    {
        $attributes = $request->all();

        $node = $this->repository->store($attributes);

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
