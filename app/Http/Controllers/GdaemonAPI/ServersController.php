<?php

namespace Gameap\Http\Controllers\GdaemonAPI;

use Gameap\Http\Requests\GdaemonAPI\JsonServerBulkRequest;
use Gameap\Http\Requests\GdaemonAPI\ServerRequest;
use Gameap\Models\DedicatedServer;
use Gameap\Models\Server;
use Gameap\Repositories\ServerRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;

class ServersController extends Controller
{
    /**
     * @var ServerRepository
     */
    protected $repository;

    public function __construct(ServerRepository $serverRepository)
    {
        parent::__construct();

        $this->repository = $serverRepository;
    }

    public function index(DedicatedServer $dedicatedServer): JsonResponse
    {
        return response()->json(
            QueryBuilder::for(Server::where('ds_id', '=', $dedicatedServer->id))
            ->allowedFilters('id')
            ->with('dedicatedServer')
            ->with('game')
            ->with('gameMod')
            ->with('settings')
            ->get()
        );
    }

    public function server(Server $server): JsonResponse
    {
        $server->getRelationValue('dedicatedServer');
        $isLinux = $server->dedicatedServer->isLinux();
        $server->unsetRelation('dedicatedServer');

        $server->getRelationValue('game');
        $server->getRelationValue('gameMod');
        $server->getRelationValue('settings');

        $fieldSiffix = 'windows';
        if($isLinux) {
            $fieldSiffix = 'linux';
        }
        $arFields = [
            'game' => [
                'remote_repository', 'local_repository', 'steam_app_id',
            ],
            'gameMod' => [
                'remote_repository', 'local_repository', 'start_cmd',
            ],
        ];
        foreach($arFields as $relationName => $arRelationFields){
            foreach($arRelationFields as $gameField){
                $server->{$relationName}->{$gameField} = $server->{$relationName}->{$gameField . '_' . $fieldSiffix};
                unset($server->{$relationName}->{$gameField . '_linux'});
                unset($server->{$relationName}->{$gameField . '_windows'});
            }
        }

        return response()->json($server);
    }

    public function update(ServerRequest $request, Server $server): JsonResponse
    {
        $server->installed = $request->installed() ?? $server->installed;
        $server->process_active = $request->processActive() ?? $server->process_active;
        $server->last_process_check = $request->lastProcessCheck() ?? $server->last_process_check;

        $this->repository->save($server);

        return response()->json(['message' => 'success'], Response::HTTP_OK);
    }

    public function updateBulk(JsonServerBulkRequest $request): JsonResponse
    {
        $this->repository->saveBatch($request->values());

        return response()->json(['message' => 'success'], Response::HTTP_OK);
    }
}
