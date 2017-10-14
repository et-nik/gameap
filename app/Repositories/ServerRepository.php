<?php

namespace Gameap\Repositories;

use Gameap\Models\Server;

class ServerRepository
{
    public function getAll($perPage = 20)
    {
        if (!$perPage) {
            $servers = Server::orderBy('id')->with('game');
        } else {
            $servers = Server::orderBy('id')->with('game')->paginate($perPage);
        }

        return $servers;
    }
}