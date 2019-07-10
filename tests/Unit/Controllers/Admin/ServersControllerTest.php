<?php

namespace Tests\Unit\Admin;

use Gameap\Exceptions\Repositories\RecordExistExceptions;
use Gameap\Http\Requests\Admin\ServerDestroyRequest;
use Gameap\Models\Server;
use Gameap\Models\GdaemonTask;
use Gameap\Repositories\GdaemonTaskRepository;
use Illuminate\Http\Response;
use Tests\TestCase;
use Gameap\Http\Controllers\Admin\ServersController;
use Gameap\Http\Requests\Admin\ServerUpdateRequest;
use Gameap\Http\Requests\Admin\ServerCreateRequest;
use Illuminate\Container\Container;
use Mockery;

/**
 * @covers \Gameap\Http\Controllers\Admin\ServersController<extended>
 */
class ServersControllerTest extends TestCase
{
    /**
     * @var ServersController
     */
    protected $controller;

    /**
     * @var Container
     */
    protected $container;

    protected function setUp(): void
    {
        parent::setUp();

        $this->container = Container::getInstance();
        $this->controller = $this->container->make(ServersController::class);
    }

    public function testIndex()
    {
        $response = $this->controller->index();
        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
    }

    public function testCreate()
    {
        $response = $this->controller->create();
        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
    }

    public function testEdit()
    {
        $server = new Server();

        $response = $this->controller->edit($server);
        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
    }

    public function testStore()
    {
        $request = ServerCreateRequest::create('/admin/servers', ServerCreateRequest::METHOD_POST, [
            'enabled' => 1,
            'blocked' => 0,
            'installed' => 1,
            'name' => 'Test Server',
            'game_id' => 'minecraft',
            'ds_id' => 1,
            'game_mod_id' => 8,
            'server_ip' => 'localhost',
            'server_port' => 27500,
            'query_port' => 27500,
            'rcon_port' => 27501,
        ]);

        $response = $this->controller->store($request);
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
    }

    public function testUpdate()
    {
        $server = Server::first();

        $request = ServerUpdateRequest::create('/admin/servers/', ServerCreateRequest::METHOD_PATCH, [
            'name' => 'Edited Server',
            'dir' => 'Dir',
        ]);

        $response = $this->controller->update($request, $server);
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
    }

    public function testDestroy()
    {
        $server = Server::first();

        $mock = Mockery::mock(GdaemonTaskRepository::class)->makePartial();
        $this->container->instance(GdaemonTaskRepository::class, $mock);
        $mock->shouldNotReceive('addServerDelete');

        $request = ServerDestroyRequest::create('/admin/servers/', ServerCreateRequest::METHOD_DELETE, []);
        $response = $this->controller->destroy($request, $server);
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
    }

    public function testDestroyDeleteFiles()
    {
        $server = Server::first();

        $mock = Mockery::mock(GdaemonTaskRepository::class)->makePartial();
        $this->container->instance(GdaemonTaskRepository::class, $mock);

        $mock->shouldReceive('addServerDelete')->andReturn([
            'run_aft_id' => 0,
            'dedicated_server_id' => $server->ds_id,
            'server_id' => $server->id,
            'task' => GdaemonTask::TASK_SERVER_DELETE,
        ])->andThrow(RecordExistExceptions::class);

        $request = ServerDestroyRequest::create('/admin/servers/', ServerCreateRequest::METHOD_DELETE, [
            'delete_files' => 'delete_files'
        ]);
        $response = $this->controller->destroy($request, $server);

        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());

        $request = ServerDestroyRequest::create('/admin/servers/', ServerCreateRequest::METHOD_DELETE, [
            'delete_files' => 'delete_files'
        ]);
        $response = $this->controller->destroy($request, $server);
    }
}