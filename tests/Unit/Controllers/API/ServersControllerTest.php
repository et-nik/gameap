<?php

namespace Tests\Unit\Controllers\API;

use Gameap\Exceptions\Repositories\GdaemonTaskRepository\EmptyServerStartCommandException;
use Gameap\Exceptions\Repositories\GdaemonTaskRepository\GdaemonTaskRepositoryException;
use Gameap\Http\Controllers\API\ServersController;
use Gameap\Models\Server;
use Gameap\Models\User;
use Gameap\Repositories\GdaemonTaskRepository;
use Gameap\Repositories\ServerRepository;
use Gameap\Services\ServerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Tests\TestCase;

/**
 * @covers \Gameap\Http\Controllers\API\ServersController
 */
class ServersControllerTest extends TestCase
{
    /** @var ServersController */
    protected $controller;

    /** @var ServerRepository|\Mockery\MockInterface */
    protected $serverRepositoryMock;

    /** @var GdaemonTaskRepository|\Mockery\MockInterface */
    protected $gdaemonTaskRepositoryMock;

    /** @var ServerService|\Mockery\MockInterface */
    protected $serverServiceMock;

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->serverRepositoryMock = Mockery::mock(ServerRepository::class);
        $this->gdaemonTaskRepositoryMock = Mockery::mock(GdaemonTaskRepository::class);
        $this->serverServiceMock = Mockery::mock(ServerService::class);

        $this->controller = $this->createPartialMock(ServersController::class, ['authorize']);
        $this->controller->__construct(
            $this->serverRepositoryMock,
            $this->gdaemonTaskRepositoryMock,
            $this->serverServiceMock
        );
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function testStart(): void
    {
        $this->controller->method('authorize')->willReturn(true);
        $this->gdaemonTaskRepositoryMock->shouldReceive('addServerStart')->andReturn(15);

        $result = $this->controller->start(new Server());
        $this->assertEquals([
            'gdaemonTaskId' => 15
        ], $result);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function testStartFailRepositoryException(): void
    {
        $this->be(User::find(1));

        $this->controller->method('authorize')->willReturn(true);
        $this->gdaemonTaskRepositoryMock
            ->shouldReceive('addServerStart')
            ->andThrow(new EmptyServerStartCommandException('Test Exception'));

        $result = $this->controller->start(new Server());

        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertNotEmpty($result->getData()->message);
        // $this->assertEquals(__('main.common_admin_error'), $result->getData()->message);
    }

}