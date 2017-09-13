<?php

namespace Gameap\Http\Controllers;

use Illuminate\Routing\Controller;
use Gameap\Models\Server;

class ServersController extends Controller {

    public function index()
    {
        $server = Server::find(1);

        print_r($server);

//        $server->save();
    }
}