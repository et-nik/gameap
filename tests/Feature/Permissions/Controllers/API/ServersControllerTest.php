<?php

namespace Tests\Feature\Permissions\Controllers\API;

use Gameap\Models\Server;
use Gameap\Models\ServerTask;
use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;
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
            ['post', 'api.servers.store', []],
            ['put', 'api.servers.save', ['server' => $this->server->id]],
            ['delete', 'api.servers.destroy', ['server' => $this->server->id]],
        ];
    }

    public function testForbidden()
    {
        $this->setCurrentUserRoles(['user']);

        $data = $this->routesDataProvider();

        // dataProvider doesn't work how I expect
        // I don't want to spend a lot of time to find why it doesn't work
        // I rewrite to Golang code faster than found why it doesn't work in PHP
        // I hate PHP and PHPUnit
        foreach ($data as $item) {
            $method = $item[0];
            $route = $item[1];
            $params = $item[2] ?? [];

            $response = $this->{$method}(route($route, $params), []);
            $response->assertStatus(Response::HTTP_FORBIDDEN);
        }
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
            ['put', 'api.servers.update_task', ['server' => $this->server->id, 'server_task' => $this->task]],
            ['delete', 'api.servers.delete_task', ['server' => $this->server->id, 'server_task' => $this->task]],
            ['get', 'api.servers.get_settings', ['server' => $this->server->id]],
            ['put', 'api.servers.save_settings', ['server' => $this->server->id]],
        ];
    }

    public function testForbiddenForUser()
    {
        $this->setCurrentUserRoles(['user']);

        $data = $this->userRoutesDataProvider();

        // dataProvider doesn't work how I expect
        // I don't want to spend a lot of time to find why it doesn't work
        // I rewrite to Golang code faster than found why it doesn't work in PHP
        // I hate PHP and PHPUnit
        foreach ($data as $item) {
            $method = $item[0];
            $route = $item[1];
            $params = $item[2] ?? [];

            /** @var TestResponse $response */
            $response = $this->{$method}(route($route, $params), []);
            if ($response->status() !== Response::HTTP_FORBIDDEN) {
            	$this->fail('Response status is '. $response->status() .' should be 403, for route "'. $route . '" with params: ' . json_encode($params));
            }
        }
    }
}