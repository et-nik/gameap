<?php

namespace Gameap\Http\Controllers\GdaemonAPI;

use Gameap\Models\DedicatedServer;

class DedicatedServersController extends Controller
{
    /**
     * Get Initial Dedicated server data
     * 
     * @param DedicatedServer $dedicatedServer
     *
     * @return array
     */
    public function getInitData(DedicatedServer $dedicatedServer) 
    {
        return [
            'work_path' => $dedicatedServer->work_path,

            'script_start' => $dedicatedServer->script_start,
            'script_stop' => $dedicatedServer->script_stop,
            'script_restart' => $dedicatedServer->script_restart,
            'script_status' => $dedicatedServer->script_status,
            'script_get_console' => $dedicatedServer->script_get_console,
            'script_send_command' => $dedicatedServer->script_get_console,
        ];
    }
}