<?php

namespace Gameap\Policies;

use Gameap\Models\Server;
use Gameap\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServerPolicy
{
    use HandlesAuthorization;

    public function before(?User $user, $ability)
    {
        if ($user !== null && $user->can('admin roles & permissions')) {
            return true;
        }

        return null;
    }

    public function control(?User $user, Server $server): bool
    {
        if ($user === null) {
            return false;
        }

        $exists = $user->servers()
            ->where('id', $server->id)
            ->exists();
        return $exists && $user->can('game-server-common', $server);
    }

    public function start(User $user, Server $server): bool
    {
        return $user !== null && $user->can(['game-server-common', 'game-server-start'], $server);
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
    public function tasks(User $user, Server $server)
    {
        return $user->can(['game-server-common', 'game-server-tasks'], $server)
            && (
                $this->start($user, $server)
                || $this->stop($user, $server)
                || $this->restart($user, $server)
                || $this->update($user, $server)
            );
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

    /**
     * Main Rcon
     *
     * @param User $user
     * @param Server $server
     * @return bool
     */
    public function rcon(User $user, Server $server)
    {
        if (!$user->can('game-server-common', $server)) {
            return false;
        }

        return $user->can('game-server-rcon-console', $server)
            || $user->can('game-server-rcon-players', $server);
    }

    /**
     * @param User $user
     * @param Server $server
     * @return bool
     */
    public function rconConsole(User $user, Server $server)
    {
        return $user->can(['game-server-common', 'game-server-rcon-console'], $server);
    }

    /**
     * @param User $user
     * @param Server $server
     * @return bool
     */
    public function rconPlayers(User $user, Server $server)
    {
        if (!$user->can('game-server-common', $server)) {
            return false;
        }

        return $user->can('game-server-rcon-console')
            || $user->can('game-server-rcon-players', $server);
    }
}
