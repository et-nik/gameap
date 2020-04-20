<?php

namespace Tests\Unit\Controllers\API;

use Gameap\Exceptions\Repositories\GdaemonTaskRepository\GdaemonTaskRepositoryException;
use Gameap\Exceptions\Repositories\RecordExistExceptions;
use Gameap\Http\Controllers\API\ServersController;
use Gameap\Models\Server;
use Gameap\Models\User;
use Gameap\Repositories\GdaemonTaskRepository;
use Gameap\Repositories\ServerRepository;
use Gameap\Services\ServerControlService;
use Gameap\Services\ServerService;
use Illuminate\Auth\Access\AuthorizationException;
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

    /** @var ServerControlService|\Mockery\MockInterface */
    protected $serverControlServiceMock;

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->serverRepositoryMock = Mockery::mock(ServerRepository::class);
        $this->gdaemonTaskRepositoryMock = Mockery::mock(GdaemonTaskRepository::class);
        $this->serverServiceMock = Mockery::mock(ServerService::class);
        $this->serverControlServiceMock = Mockery::mock(ServerControlService::class);

        $this->controller = $this->createPartialMock(ServersController::class, ['authorize']);
        $this->controller->__construct(
            $this->serverRepositoryMock,
            $this->gdaemonTaskRepositoryMock,
            $this->serverServiceMock,
            $this->serverControlServiceMock
        );
    }

    /**
     * @throws AuthorizationException
     */
    public function testStart(): void
    {
        $this->controller->method('authorize')->willReturn(true);
        $this->serverControlServiceMock->shouldReceive('start')->andReturn(15);

        $result = $this->controller->start(new Server());
        $this->assertEquals([
            'gdaemonTaskId' => 15
        ], $result);
    }

    /**
     * @throws AuthorizationException
     */
    public function testStartFailRepositoryException(): void
    {
        $user = factory(User::class)->create();
        Bouncer::sync($user)->roles(['admin']);
        $this->be($user);

        $this->controller->method('authorize')->willReturn(true);

        $this->serverControlServiceMock->shouldReceive('start')
            ->andThrow(new GdaemonTaskRepositoryException('Test Exception'));

        $result = $this->controller->start(new Server());

        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertNotEmpty($result->getData()->message);
        $this->assertEquals('Test Exception', $result->getData()->message);
    }

    /**
     * @throws AuthorizationException
     */
    public function testStartExists(): void
    {
        $user = factory(User::class)->create();
        Bouncer::sync($user)->roles(['admin']);
        $this->be($user);

        $this->controller->method('authorize')->willReturn(true);

        $this->serverControlServiceMock->shouldReceive('start')
            ->andThrow(new RecordExistExceptions('Test Exists Exception'));

        $this->gdaemonTaskRepositoryMock
            ->shouldReceive('getOneWorkingTaskId')
            ->andReturn(15);

        $server = new Server();
        $server->id = 1;
        
        $result = $this->controller->start($server);
        $this->assertEquals([
            'gdaemonTaskId' => 15
        ], $result);
    }

}