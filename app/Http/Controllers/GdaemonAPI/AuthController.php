<?php

namespace Gameap\Http\Controllers\GdaemonAPI;

use Carbon\Carbon;
use Gameap\Models\DedicatedServer;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;

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
            'token'     => $dedicatedServer->gdaemon_api_token,
            'timestamp' => Carbon::now()->timestamp,
        ]);
    }
}
