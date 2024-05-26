<?php

namespace Tests\Feature\Permissions\Controllers\API;

use Illuminate\Http\Response;
use Tests\Feature\Permissions\PermissionsTestCase;

class DedicatedServersControllerTest extends PermissionsTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function routesDataProvider()
    {
        return [
            ['get', 'api.dedicated_servers', []],
            ['get', 'api.dedicated_servers.summary', []],
            ['get', 'api.dedicated_servers.setup', []],
            ['get', 'api.dedicated_servers.certificates', []],
            ['get', 'api.dedicated_servers.logs', ['dedicated_server' => 1]],
            ['get', 'api.dedicated_servers.get', ['dedicated_server' => 1]],
            ['get', 'api.dedicated_servers.daemon', ['dedicated_server' => 1]],
            ['get', 'api.dedicated_servers.ip_list', ['dedicated_server' => 1]],
            ['get', 'api.dedicated_servers.busy_ports', ['dedicated_server' => 1]],
            ['post', 'api.dedicated_servers.store', []],
            ['put', 'api.dedicated_servers.update', ['id' => 1]],
            ['delete', 'api.dedicated_servers.destroy', ['id' => 1]],
        ];
    }

    public function testForbidden()
    {
        $this->setCurrentUserRoles(['user']);

        $data = $this->routesDataProvider();

        // dataProvider doesn't work how I expect
        // I don't want to spend a lot of time to find why it doesn't work
        // I rewrite to Golang code faster than found why it doesn't work
        // I hate PHP and PHPUnit
        foreach ($data as $item) {
            $method = $item[0];
            $route = $item[1];
            $params = $item[2] ?? [];

            $response = $this->{$method}(route($route, $params), $data);
            $response->assertStatus(Response::HTTP_FORBIDDEN);
        }
    }
}