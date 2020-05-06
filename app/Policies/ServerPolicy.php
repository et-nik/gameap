<?php

namespace Gameap\Policies;

use Gameap\Models\User;
use Gameap\Models\Server;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServerPolicy
{
    use HandlesAuthorization;

    public function before(?User $user, $ability)
    {
        if ($user->can('admin roles & permissions')) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view the server.
     *
     * @param User $user
     * @param Server $server
     * @return mixed
     */
    public function control(?User $user, Server $server)
    {
        $exists = $user->servers()
            ->where('id', $server->id)
            ->exists();
        return $exists && $user->can('game-server-common', $server);
    }

    /**
     * @param User $user
     * @param Server $server
     * @return bool
     */
    public function start(User $user, Server $server)
    {
        return $user->can(['game-server-common', 'game-server-start'], $server);
    }

    /**
     * @param User $user
     * @param Server $server
     * @return bool
     */
    public function stop(User $user, Server $server)
    {
        return $user->can(['game-server-common', 'game-server-stop'], $server);
    }

    /**
     * @param User $user
     * @param Server $server
     * @return bool
     */
    public function restart(User $user, Server $server)
    {
        return $user->can(['game-server-common', 'game-server-restart'], $server);
    }

    /**
     * @param User $user
     * @param Server $server
     * @return bool
     */
    public function pause(User $user, Server $server)
    {
        return $user->can(['game-server-common', 'game-server-pause'], $server);
    }

    /**
     * @param User $user
     * @param Server $server
     * @return bool
     */
    public function update(User $user, Server $server)
    {
        return $user->can(['game-server-common', 'game-server-update'], $server);
    }

    /**
     * @param User $user
     * @param Server $server
     * @return bool
     */
    public function consoleView(User $user, Server $server)
    {
        return $user->can(['game-server-common', 'game-server-console-view'], $server);
    }

    /**
     * @param User $user
     * @param Server $server
     * @return bool
     */
    public function consoleSend(User $user, Server $server)
    {
        return $user->can(['game-server-common', 'game-server-console-send'], $server);
    }

    /**
     * @param User $user
     * @param Server $server
     * @return bool
     */
    public function files(User $user, Server $server)
    {
        return $user->can(['game-server-common', 'game-server-files'], $server);
    }

    /**
     * @param User $user
     * @param Server $server
     * @return bool
     */
    public function settings(User $user, Server $server)
    {
        return $user->can(['game-server-common', 'game-server-settings'], $server);
    }
}
