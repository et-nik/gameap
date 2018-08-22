<?php

namespace Gameap\Http\Controllers\GdaemonAPI;

use Gameap\Models\Server;

class ServersController extends Controller
{
    public function getServer(Server $server)
    {
        return $server;
    }
}