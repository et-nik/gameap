<?php

namespace Tests\Feature\Permissions\Controllers\API;

use Gameap\Models\Server;
use Gameap\Models\ServerTask;
use Illuminate\Http\Response;
use Tests\Feature\Permissions\PermissionsTestCase;

class ServersControllerTest extends PermissionsTestCase
{
    /** @var Server */
    private $server;

    /** @var ServerTask */
    private $task;

    public function setUp(): void
    {
        parent::setUp();

        $this->server = factory(Server::class)->create();
        $this->task = factory(ServerTask::class)->create(['server_id' => $this->server->id]);
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
            ['put', 'api.servers.update_task', [$this->server->id, $this->task]],
            ['delete', 'api.servers.delete_task', [$this->server->id, $this->task]],
            ['get', 'api.servers.get_settings', ['server' => $this->server->id]],
            ['put', 'api.servers.save_settings', ['server' => $this->server->id]],
        ];
    }

    /**
     * $dataProvider userRoutesDataProvider
     *
     * @param string $method
     * @param string $route
     * @param array $params
     */
    public function testForbiddenForUser(string $method, string $route, array $params = [])
    {
        $this->setCurrentUserRoles(['user']);

        $response = $this->{$method}(route($route, $params), []);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}