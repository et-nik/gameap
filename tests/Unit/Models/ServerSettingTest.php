<?php

namespace Tests\Unit\Models;

use Gameap\Models\ServerSetting;
use Gameap\Models\Server;
use Tests\TestCase;

class ServerSettingTest extends TestCase
{
    public function testServer()
    {
        factory(Server::class, 1)->create();
        $results = factory(ServerSetting::class, 1)->create();

        $serverSetting = $results->first();

        $this->assertInstanceOf(Server::class, $serverSetting->server);
    }
}