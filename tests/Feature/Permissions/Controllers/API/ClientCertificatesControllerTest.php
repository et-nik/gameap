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