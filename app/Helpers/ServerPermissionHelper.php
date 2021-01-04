<?php

namespace Gameap\Helpers;

use Gameap\Models\Server;

class ServerPermissionHelper
{
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
