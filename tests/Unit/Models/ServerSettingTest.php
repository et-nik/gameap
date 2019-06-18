<?php

namespace Tests\Unit\Models;

use Gameap\Models\ServerSetting;
use Gameap\Models\Server;
use Tests\TestCase;

class ServerSettingTest extends TestCase
{
    public function testServer()
    {
        factory(ServerSetting::class, 1)->create();
        $serverSetting = ServerSetting::first();

        $this->assertInstanceOf(Server::class, $serverSetting->server);
    }
}