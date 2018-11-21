<?php
namespace Gameap\Http\Controllers\GdaemonAPI;

use Gameap\Models\DsStats;
use Gameap\Models\DedicatedServer;
use Gameap\Http\Requests\GdaemonAPI\DsStatsRequest;
use Illuminate\Http\Response;

class DsStatsController extends Controller
{
    /**
     * @param DsStatsRequest $request
     */
    public function store(DsStatsRequest $request, DedicatedServer $dedicatedServer)
    {
        $attributes = $request->only(['time', 'loa', 'ram', 'cpu', 'ifstat', 'ping', 'drvspace']);
        $attributes['dedicated_server_id'] = $dedicatedServer->id;
        DsStats::create($attributes);

        return response()->json(['message' => 'success'], Response::HTTP_CREATED);
    }
}