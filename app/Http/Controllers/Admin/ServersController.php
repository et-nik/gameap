<?php

namespace Gameap\Http\Controllers\Admin;

use Gameap\Http\Controllers\Controller;
use Gameap\Models\Server;

class ServersController extends Controller {

    public function index()
    {
        $server = Server::find(1);

        print_r($server);

//        $server->save();
    }
}