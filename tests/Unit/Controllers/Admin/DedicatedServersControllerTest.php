<?php

namespace Tests\Unit\Controllers\Admin;

use Gameap\Http\Controllers\Admin\DedicatedServersController;
use Gameap\Http\Requests\Admin\DedicatedServerRequest;
use Gameap\Http\Requests\ClientCertificatesRequest;
use Gameap\Models\DedicatedServer;
use Gameap\Repositories\DedicatedServersRepository;
use Illuminate\Container\Container;
use Illuminate\Http\Response;
use Mockery;
use Tests\TestCase;

/**
 * @covers \Gameap\Http\Controllers\Admin\DedicatedServersController
 */
class DedicatedServersControllerTest extends TestCase
{
    /** @var DedicatedServersController */
    protected $controller;

    /** @var DedicatedServersRepository|\Mockery\MockInterface $repository */
    protected $repositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repositoryMock = Mockery::mock(DedicatedServersRepository::class);
        $container = Container::getInstance();
        $container->instance(DedicatedServersRepository::class, $this->repositoryMock);
        $this->controller = $container->make(DedicatedServersController::class);
    }

    public function testIndex()
    {
        $this->repositoryMock->shouldReceive('getAll')->andReturn(
            [Mockery::mock(DedicatedServer::class)]
        );

        $response = $this->controller->index();
        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
    }

    public function testCreate()
    {
        $response = $this->controller->create();
        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
    }

    public function testShow()
    {
        $response = $this->controller->show(Mockery::mock(DedicatedServer::class));
        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
    }

    public function testEdit()
    {
        $response = $this->controller->edit(Mockery::mock(DedicatedServer::class));
        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
    }

    public function testDestroy()
    {
        $this->repositoryMock->shouldReceive('destroy')->andReturnNull();

        $response = $this->controller->destroy(Mockery::mock(DedicatedServer::class));
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertNotEmpty($response->getSession()->get('success'));
    }

    public function testStore()
    {
        $this->repositoryMock->shouldReceive('store')->andReturn(Mockery::mock(DedicatedServer::class));

        $request = DedicatedServerRequest::create(
            '/admin/dedicated_servers/',
            ClientCertificatesRequest::METHOD_POST,
            [
                'enabled' => true,
                'name' => 'Test Dedicate server',
                'os' => 'Linux',
            ]
        );

        $response = $this->controller->store($request);
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertNotEmpty($response->getSession()->get('success'));
        $this->assertEmpty($response->getSession()->get('errors'));
    }

    public function testUpdate()
    {
        $this->repositoryMock->shouldReceive('update')->andReturnNull();

        $request = DedicatedServerRequest::create(
            '/admin/dedicated_servers/',
            ClientCertificatesRequest::METHOD_POST,
            [
                'enabled' => true,
                'name' => 'Test Dedicate server',
                'os' => 'Linux',
            ]
        );

        $response = $this->controller->update($request, Mockery::mock(DedicatedServer::class));
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertNotEmpty($response->getSession()->get('success'));
        $this->assertEmpty($response->getSession()->get('errors'));
    }
}