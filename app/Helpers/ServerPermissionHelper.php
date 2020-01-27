<?php

namespace Gameap\Helpers;

use Bouncer;
use Gameap\Models\Server;
use Gameap\Models\User;

class ServerPermissionHelper
{
    /**
     * @var array All game server permission
     */
    private static $allServersPermissions = [
        'game-servers-common',
        'game-server-start',
        'game-server-stop',
        'game-server-restart',
        'game-server-pause',
        'game-server-update',
        'game-server-console-view',
        'game-server-console-send',
        'game-server-files',
    ];

    public static function getAllPermissions()
    {
        return self::$allServersPermissions;
    }

    /**
     * @param User $user
     * @param Server[]|Server|int $servers
     * @param string $permission
     */
    public static function assignPermission(User $user, $servers, $permission = null)
    {
        if ($servers instanceof Server) {
            $servers = [$servers];
        }

        foreach ($servers as $server) {
            if (is_int($server) || is_string($server)) {
                $server = Server::findOrFail((int)$server);
            }

            if (!$server instanceof Server) {
                continue;
            }

            Bouncer::allow($user)->toOwn($server);
            if ($permission != null) {
                $user->allow($permission, $server);
            } else {
                $user->allow(self::$allServersPermissions, $server);
            }
        }
    }

    /**
     * @param User $user
     * @param Server[]|Server|int $servers
     * @param string $permission
     */
    public static function detachPermission(User $user, $servers, $permission = null)
    {
        if ($servers instanceof Server) {
            $servers = [$servers];
        }

        foreach ($servers as $server) {
            if (is_int($server) || is_string($server)) {
                $server = Server::findOrFail((int)$server);
            }

            if (!$server instanceof Server) {
                continue;
            }

            if ($permission != null) {
                $user->disallow($permission, $server);
            } else {
                $user->disallow(self::$allServersPermissions, $server);
            }
        }
    }

    /**
     * @param User $user
     */
    public static function detachFromAll(User $user)
    {
        foreach (Server::get('id')->all() as $server) {
            $user->disallow(self::$allServersPermissions, $server);
        }
    }
}