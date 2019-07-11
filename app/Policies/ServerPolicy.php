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
    }

    /**
     * Determine whether the user can view the server.
     *
     * @param  \Gameap\Models\User  $user
     * @param  \Gameap\Models\Server  $server
     * @return mixed
     */
    public function control(?User $user, Server $server)
    {
        $count = $user->servers()
            ->where('id', $server->id)
            ->count();

        return $count > 0;
    }
}
