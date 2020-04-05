<?php

namespace Tests\Unit\Repositories;

use Gameap\Exceptions\Repositories\RepositoryValidationException;
use Gameap\Models\DedicatedServer;
use Gameap\Models\Server;
use Gameap\Models\ServerTask;
use Gameap\Repositories\ServersTasksRepository;
use Illuminate\Container\Container;
use Tests\TestCase;

/**
 * @covers \Gameap\Repositories\ServersTasksRepository
 */
class ServersTasksRepositoryTest extends TestCase
{
    /** @var ServersTasksRepository */
    protected $repository;

    /** @var Server */
    protected $server;

    /** @var ServerTask */
    protected $serverTask;

    /** @var DedicatedServer */
    protected $dedicatedServer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->dedicatedServer = factory(DedicatedServer::class)->create();
        $this->server = factory(Server::class)->create([
            'ds_id' => $this->dedicatedServer->id,
        ]);

        $container = Container::getInstance();
        $this->repository = $container->make(ServersTasksRepository::class);
    }

    public function testGetTasks()
    {
        $this->serverTask = factory(ServerTask::class)->create([
            'server_id'         => $this->server,
            'repeat_period'     => 600, // 10 minutes
        ]);

        $firstTask = $this->repository->getTasks($this->server->id)[0];

        $this->assertIsArray($firstTask);
        $this->assertEquals($this->serverTask->id, $firstTask['id']);
        $this->assertEquals('10 minutes', $firstTask['repeat_period']);
    }

    public function testStore()
    {
        $this->repository->store([
            'command'       => 'start',
            'server_id'     => $this->server->id,
            'repeat_period' => '10 minutes',
            'repeat'        => 0,
            'execute_date'  => date('Y-m-d H:i:s'),
        ]);

        $serverTask = ServerTask::where('server_id', $this->server->id)->first();

        $this->assertEquals('start', $serverTask->command);
        $this->assertEquals(0, $serverTask->repeat);
        $this->assertEquals(600, $serverTask->repeat_period);
    }

    public function testStoreRepeatOnce()
    {
        $this->repository->store([
            'command'       => 'start',
            'server_id'     => $this->server->id,
            'repeat_period' => '10 minutes',
            'repeat'        => 1,
            'execute_date'  => date('Y-m-d H:i:s'),
        ]);

        $serverTask = ServerTask::where('server_id', $this->server->id)->first();

        $this->assertEquals('start', $serverTask->command);
        $this->assertEquals(1, $serverTask->repeat);
        $this->assertEquals(0, $serverTask->repeat_period);
    }

    public function testStoreEmptyCommandFail()
    {
        $this->expectException(RepositoryValidationException::class);
        $this->expectExceptionMessage(__('servers_tasks.errors.empty_command'));
        $this->repository->store([]);
    }

    public function testStoreEmptyPeriodFail()
    {
        $this->expectException(RepositoryValidationException::class);
        $this->expectExceptionMessage(__('servers_tasks.errors.empty_period'));
        $this->repository->store([
            'command'       => 'start',
            'server_id'     => $this->server->id,
            'repeat'        => 0,
            'execute_date'  => date('Y-m-d H:i:s'),
        ]);
    }

    public function testStoreMinPeriodFail()
    {
        $this->expectException(RepositoryValidationException::class);
        $this->expectExceptionMessage(__('servers_tasks.errors.minimum_period'));
        $this->repository->store([
            'command'       => 'start',
            'server_id'     => $this->server->id,
            'repeat'        => 0,
            'repeat_period' => '1 minute',
            'execute_date'  => date('Y-m-d H:i:s'),
        ]);
    }

    public function testUpdate()
    {
        $this->serverTask = factory(ServerTask::class)->create([
            'server_id'         => $this->server,
            'repeat_period'     => 1200, // 20 minutes
        ]);

        $this->repository->update($this->serverTask->id, [
            'command'       => 'start',
            'server_id'     => $this->server->id,
            'repeat_period' => '10 minutes',
            'repeat'        => 0,
            'execute_date'  => date('Y-m-d H:i:s'),
        ]);

        $serverTask = ServerTask::where('server_id', $this->server->id)->first();

        $this->assertEquals('start', $serverTask->command);
        $this->assertEquals(0, $serverTask->repeat);
        $this->assertEquals(600, $serverTask->repeat_period);
    }

    public function testUpdateRepeatOnce()
    {
        $this->serverTask = factory(ServerTask::class)->create([
            'server_id'         => $this->server,
            'repeat_period'     => 1200, // 20 minutes
        ]);

        $this->repository->update($this->serverTask->id, [
            'command'       => 'start',
            'server_id'     => $this->server->id,
            'repeat_period' => '10 minutes',
            'repeat'        => 1,
            'execute_date'  => date('Y-m-d H:i:s'),
        ]);

        $serverTask = ServerTask::where('server_id', $this->server->id)->first();

        $this->assertEquals('start', $serverTask->command);
        $this->assertEquals(1, $serverTask->repeat);
        $this->assertEquals(0, $serverTask->repeat_period);
    }

    public function testStoreUpdateTaskFail()
    {
        $this->serverTask = factory(ServerTask::class)->create();

        $this->expectException(RepositoryValidationException::class);
        $this->expectExceptionMessage(__('servers_tasks.errors.empty_command'));
        $this->repository->update($this->serverTask->id, []);
    }

    public function testUpdateEmptyPeriodFail()
    {
        $this->serverTask = factory(ServerTask::class)->create();

        $this->expectException(RepositoryValidationException::class);
        $this->expectExceptionMessage(__('servers_tasks.errors.empty_period'));
        $this->repository->update($this->serverTask->id, [
            'command'       => 'start',
            'server_id'     => $this->server->id,
            'repeat'        => 0,
            'execute_date'  => date('Y-m-d H:i:s'),
        ]);
    }

    public function testUpdateMinPeriodFail()
    {
        $this->serverTask = factory(ServerTask::class)->create();

        $this->expectException(RepositoryValidationException::class);
        $this->expectExceptionMessage(__('servers_tasks.errors.minimum_period'));
        $this->repository->update($this->serverTask->id, [
            'command'       => 'start',
            'server_id'     => $this->server->id,
            'repeat'        => 0,
            'repeat_period' => '1 minute',
            'execute_date'  => date('Y-m-d H:i:s'),
        ]);
    }
}
