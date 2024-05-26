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
            ['get', 'api.dedicated_servers'],
            ['get', 'api.dedicated_servers.summary'],
            ['get', 'api.dedicated_servers.setup'],
            ['get', 'api.dedicated_servers.certificates'],
            ['get', 'api.dedicated_servers.logs', ['dedicated_server' => 1]],
            ['get', 'api.dedicated_servers.get', ['dedicated_server' => 1]],
            ['get', 'api.dedicated_servers.daemon', ['dedicated_server' => 1]],
            ['get', 'api.dedicated_servers.ip_list', ['dedicated_server' => 1]],
            ['get', 'api.dedicated_servers.busy_ports', ['dedicated_server' => 1]],
            ['post', 'api.dedicated_servers.store'],
            ['put', 'api.dedicated_servers.update', ['dedicated_server' => 1]],
            ['delete', 'api.dedicated_servers.destroy', ['dedicated_server' => 1]],
        ];
    }

    /**
     * @dataProvider routesDataProvider
     */
    public function testForbidden($method, $route, $params = [], $data = [])
    {
        $this->setCurrentUserRoles(['user']);

        $response = $this->{$method}(route($route, $params), $data);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}