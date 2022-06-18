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
            'work_path'             => $dedicatedServer->work_path,
            'steamcmd_path'         => $dedicatedServer->steamcmd_path,
            'prefer_install_method' => $dedicatedServer->prefer_install_method,
            'script_install'        => $dedicatedServer->script_install,
            'script_reinstall'      => $dedicatedServer->script_reinstall,
            'script_update'         => $dedicatedServer->script_update,
            'script_start'          => $dedicatedServer->script_start,
            'script_pause'          => $dedicatedServer->script_pause,
            'script_unpause'        => $dedicatedServer->script_unpause,
            'script_stop'           => $dedicatedServer->script_stop,
            'script_kill'           => $dedicatedServer->script_kill,
            'script_restart'        => $dedicatedServer->script_restart,
            'script_status'         => $dedicatedServer->script_status,
            'script_get_console'    => $dedicatedServer->script_get_console,
            'script_send_command'   => $dedicatedServer->script_send_command,
            'script_delete'         => $dedicatedServer->script_delete,
        ];
    }
}
