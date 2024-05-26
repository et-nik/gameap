<?php

namespace Tests\Feature\Permissions\Controllers\API;

use Illuminate\Http\Response;
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
            ['delete', 'api.client_certificates.destroy', ['id' => 1]],
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