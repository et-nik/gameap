<?php

namespace Gameap\Http\Controllers\GdaemonAPI;

use Gameap\Http\Requests\GdaemonAPI\ServerTaskUpdateRequest;
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
    public function getList(int $serverId)
    {
        return ServerTask::where('server_id', $serverId)->get();
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