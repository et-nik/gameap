<?php

namespace Tests\Unit\Controllers\API;

use Gameap\Exceptions\Repositories\GdaemonTaskRepository\GdaemonTaskRepositoryException;
use Gameap\Http\Controllers\API\ServersController;
use Gameap\Models\Server;
use Gameap\Models\User;
use Gameap\Repositories\GdaemonTaskRepository;
use Gameap\Repositories\ServerRepository;
use Gameap\Services\ServerControlService;
use Gameap\Services\ServerService;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;
use Mockery;
use Bouncer;

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
            $this->serverServiceMock,
            new ServerControlService($this->gdaemonTaskRepositoryMock)
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
        $user = factory(User::class)->create();
        Bouncer::sync($user)->roles(['admin']);
        $this->be($user);

        $this->controller->method('authorize')->willReturn(true);
        $this->gdaemonTaskRepositoryMock
            ->shouldReceive('addServerStart')
            ->andThrow(new GdaemonTaskRepositoryException('Test Exception'));

        $result = $this->controller->start(new Server());

        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertNotEmpty($result->getData()->message);
        $this->assertEquals('Test Exception', $result->getData()->message);
    }

}