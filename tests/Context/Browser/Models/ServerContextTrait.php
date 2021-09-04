<?php

namespace Tests\Context\Browser\Models;

use Gameap\Models\Server;

trait ServerContextTrait
{
    private function givenGameServer($name = 'Test'): Server
    {
        return factory(Server::class)->create([
            'name'              => $name,
            'installed'         => 1,
        ]);
    }
}
