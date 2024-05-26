<?php

namespace Tests\Feature\Permissions\Controllers\API;

use Gameap\Models\User;
use Gameap\Repositories\UserRepository;
use Illuminate\Http\Response;
use Silber\Bouncer\Bouncer;
use Tests\Feature\Permissions\PermissionsTestCase;

class ClientCertificatesControllerTest extends PermissionsTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function routesDataProvider()
    {
        return [
            ['get', 'api.client_certificates'],
            ['post', 'api.client_certificates.store'],
            ['delete', 'api.client_certificates.destroy', 1],
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