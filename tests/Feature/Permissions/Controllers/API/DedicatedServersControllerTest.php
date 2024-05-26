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
            ['get', 'api.dedicated_servers.logs', 1],
            ['get', 'api.dedicated_servers.get', 1],
            ['get', 'api.dedicated_servers.daemon', 1],
            ['get', 'api.dedicated_servers.ip_list', 1],
            ['get', 'api.dedicated_servers.busy_ports', 1],
            ['post', 'api.dedicated_servers.store'],
            ['put', 'api.dedicated_servers.update', 1],
            ['delete', 'api.dedicated_servers.destroy', 1],
        ];
    }

    /**
     * @dataProvider routesDataProvider
     */
    public function testForbidden($method, $route, $param = null, $data = [])
    {
        $this->setCurrentUserRoles(['user']);

        $response = $this->{$method}(route($route, $param), $data);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}