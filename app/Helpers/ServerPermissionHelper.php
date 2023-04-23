<?php

namespace Gameap\Helpers;

use Gameap\Models\Server;

class ServerPermissionHelper
{
    const CONTROL_ABILITY = 'server-control';
    const START_ABILITY = 'server-start';
    const STOP_ABILITY = 'server-stop';
    const RESTART_ABILITY = 'server-restart';
    const UPDATE_ABILITY = 'server-update';
    const CONSOLE_VIEW_ABILITY = 'server-console-view';
    const CONSOLE_SEND_ABILITY = 'server-console-send';

    /**
     * @var array All game server permission
     */
    private static $allServersPermissions = [
        'game-server-common',
        'game-server-start',
        'game-server-stop',
        'game-server-restart',
        'game-server-pause',
        'game-server-update',
        'game-server-files',
        'game-server-tasks',
        'game-server-settings',

        // Console
        'game-server-console-view',
        'game-server-console-send',

        // RCON
        'game-server-rcon-console',
        'game-server-rcon-players',
    ];

    public static function getAllPermissions()
    {
        return self::$allServersPermissions;
    }
}
