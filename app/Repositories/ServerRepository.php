<?php

namespace Gameap\Repositories;

use Gameap\Models\Server;
use Gameap\Http\Requests\ServerRequest;

class ServerRepository
{
    public function getAll($perPage = 20)
    {
        $servers = Server::orderBy('id')->with('game')->paginate($perPage);

        return $servers;
    }

    /**
     * Store server
     * 
     * @param \Gameap\Http\Requests\ServerRequest  $request
     */
    public function store(ServerRequest $request)
    {
        Server::create($request->all());
    }
}