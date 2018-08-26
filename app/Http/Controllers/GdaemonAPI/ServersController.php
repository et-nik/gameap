<?php

namespace Gameap\Http\Controllers\GdaemonAPI;

use Gameap\Models\Server;
use Gameap\Models\DedicatedServer;
use Gameap\Repositories\ServerRepository;
use Spatie\QueryBuilder\QueryBuilder;
use Gameap\Http\Requests\GdaemonAPI\ServerRequest;
use Illuminate\Http\Response;

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
        return QueryBuilder::for(Server::where('ds_id', $dedicatedServer->id))
            ->allowedFilters('id')
            ->get();
    }

    /**
     * @param Server $server
     * @return Server
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
    public function update(Server $server)
    {
        $request = request();
        // $request2 = $request->only(['installed', 'process_active', 'last_process_check']);
        //$server->update($request->only(['installed', 'process_active', 'last_process_check']));
//        $server->get

        return response()->json(['message' => 'success'], Response::HTTP_OK);
    }
}