<?php

namespace Gameap\Http\Controllers\GdaemonAPI;

use Gameap\Http\Requests\GdaemonAPI\ServerTaskUpdateRequest;
use Gameap\Models\DedicatedServer;
use Gameap\Models\Server;
use Gameap\Models\ServerTask;
use Gameap\Repositories\ServersTasksRepository;

class ServersTasksController extends Controller
{
    /** @var ServersTasksRepository */
    protected $repository;

    public function __construct(ServersTasksRepository $serversTasksRepository)
    {
        parent::__construct();
        $this->repository = $serversTasksRepository;
    }

    /**
     * @param int $serverId
     * @return
     */
    public function getList(DedicatedServer $dedicatedServer)
    {
        return ServerTask::whereIn("server_id", function ($query) use ($dedicatedServer) {
            $query->select('id')
                ->from('servers')
                ->where('ds_id', $dedicatedServer->id);
        })->get();
    }

    /**
     * @param ServerTaskUpdateRequest $request
     * @param int $serverId
     * @param int $taskId
     * @noinspection PhpUnusedParameterInspection
     */
    public function update(ServerTaskUpdateRequest $request, int $serverId, int $taskId)
    {
        ServerTask::where('id', $taskId)->update($request->all());
    }
}