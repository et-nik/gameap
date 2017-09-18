<?php

namespace Gameap\Repositories;

use Gameap\Models\Server;

class ServerRepository
{
    public function getAll($perPage = 20)
    {
        return Server::orderBy('id')->with('game')->paginate($perPage);
    }
}