<?php

namespace Tests\Feature\Permissions\Controllers\API;

use Gameap\Models\Server;
use Illuminate\Http\Response;
use Tests\Feature\Permissions\PermissionsTestCase;

class ServersControllerTest extends PermissionsTestCase
{
    /** @var Server */
    private $server;

    public function setUp(): void
    {
        parent::setUp();

        $this->server = factory(Server::class)->create();
    }

    public function routesDataProvider()
    {
        return [
            ['api.servers.store'],
            ['api.servers.save', ['server' => $this->server->id]],
            ['api.servers.destroy', ['server' => $this->server->id]],
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

    public function userRoutesDataProvider()
    {
        /** @var Server $server */
        $server = factory(Server::class)->create();

        return [
            ['get', 'api.servers.get', ['server' => $this->server->id]],
            ['get', 'api.servers.abilities', ['server' => $this->server->id]],
            ['post', 'api.servers.start', ['server' => $this->server->id]],
            ['post', 'api.servers.stop', ['server' => $this->server->id]],
            ['post', 'api.servers.restart', ['server' => $this->server->id]],
            ['post', 'api.servers.install', ['server' => $this->server->id]],
            ['post', 'api.servers.update', ['server' => $this->server->id]],
            ['post', 'api.servers.reinstall', ['server' => $this->server->id]],
            ['get', 'api.servers.get_status', ['server' => $this->server->id]],
            ['get', 'api.servers.query', ['server' => $this->server->id]],
            ['get', 'api.servers.console', ['server' => $this->server->id]],
            ['post', 'api.servers.send_command', ['server' => $this->server->id]],
            ['get', 'api.servers.get_tasks', ['server' => $this->server->id]],
            ['post', 'api.servers.add_task', ['server' => $this->server->id]],
            ['put', 'api.servers.update_task', [$server->id, 1]],
            ['delete', 'api.servers.delete_task', [$server->id, 1]],
            ['get', 'api.servers.get_settings', ['server' => $this->server->id]],
            ['put', 'api.servers.save_settings', ['server' => $this->server->id]],
        ];
    }

    /**
     * $dataProvider userRoutesDataProvider
     */
    public function testForbiddenForUser($method, $route, $data = [])
    {
        $this->setCurrentUserRoles(['user']);

        $response = $this->{$method}(route($route, ['server' => $this->server->id]), $data);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}