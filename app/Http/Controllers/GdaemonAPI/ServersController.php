<?php

namespace Gameap\Http\Controllers\GdaemonAPI;

use Gameap\Models\Server;
use Gameap\Models\DedicatedServer;
use Gameap\Repositories\ServerRepository;
use Spatie\QueryBuilder\QueryBuilder;
use Gameap\Http\Requests\GdaemonAPI\ServerRequest;
use Gameap\Http\Requests\GdaemonAPI\ServerBulkRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Batch;

class ServersController extends Controller
{
    /**
     * @var ServerRepository
     */
    protected $repository;

    /**
     * ServersController constructor.
     * @param ServerRepository $serverRepository
     */
    public function __construct(ServerRepository $serverRepository)
    {
        parent::__construct();

        $this->repository = $serverRepository;
    }

    /**
     * @param DedicatedServer $dedicatedServer
     * @return mixed
     */
    public function index(DedicatedServer $dedicatedServer)
    {
        return QueryBuilder::for(Server::where('ds_id', '=', $dedicatedServer->id))
            ->allowedFilters('id')
            ->get();
    }

    /**
     * @param Server $server
     * @return \Illuminate\Http\JsonResponse
     */
    public function server(Server $server)
    {
        // Get Relations
        $server->getRelationValue('game');
        $server->getRelationValue('gameMod');

        return response()->json($server);
    }

    /**
     * @param Server $server
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ServerRequest $request, Server $server)
    {
        $server->forceFill($request->only(['installed', 'process_active', 'last_process_check']));
        $server->save();

        return response()->json(['message' => 'success'], Response::HTTP_OK);
    }

    /**
     * @param ServerBulkRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateBulk(ServerBulkRequest $request)
    {
        $values = array_map(function($v) {
            return Arr::only($v, ['id', 'installed', 'process_active', 'last_process_check']);
        }, $request->json()->all());

        Batch::update(new Server, $values, 'id');

        return response()->json(['message' => 'success'], Response::HTTP_OK);
    }
}