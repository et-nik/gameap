<?php

namespace Gameap\Http\Controllers\GdaemonAPI;

use Gameap\Http\Requests\GdaemonAPI\DsStatsRequest;
use Gameap\Models\DedicatedServer;
use Gameap\Models\DsStats;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class DsStatsController extends Controller
{
    /**
     * @param DsStatsRequest $request
     * @param DedicatedServer $dedicatedServer
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(DsStatsRequest $request, DedicatedServer $dedicatedServer)
    {
        $values = array_map(function ($v) use ($dedicatedServer) {
            $arr = Arr::only($v, ['time', 'loa', 'ram', 'cpu', 'ifstat', 'ping', 'drvspace']);
            $arr['dedicated_server_id'] = $dedicatedServer->id;
            return $arr;
        }, $request->all());

        DsStats::insert($values);

        return response()->json(['message' => 'success'], Response::HTTP_CREATED);
    }
}
