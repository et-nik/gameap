<?php

namespace Gameap\Http\Controllers\GdaemonAPI;

use Illuminate\Support\Str;
use Illuminate\Routing\Controller as BaseController;
use Carbon\Carbon;
use Gameap\Models\DedicatedServer;

class AuthController extends BaseController
{
    public function __construct()
    {
        $this->middleware('gdaemonApiAuth');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getToken(DedicatedServer $dedicatedServer)
    {
        $dedicatedServer->gdaemon_api_token = Str::Random(64);
        $dedicatedServer->update();

        return response()->json([
            'token' => $dedicatedServer->gdaemon_api_token,
            'timestamp' => Carbon::now()->timestamp,
        ]);
    }
}