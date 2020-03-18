<?php

namespace Tests\Unit\Controllers\GdaemonAPI;

use Gameap\Http\Controllers\GdaemonAPI\ServersTasksController;
use Gameap\Http\Requests\GdaemonAPI\ServerTaskFailRequest;
use Gameap\Http\Requests\GdaemonAPI\ServerTaskUpdateRequest;
use Gameap\Models\DedicatedServer;
use Gameap\Models\Server;
use Gameap\Models\ServerTask;
use Gameap\Models\ServerTaskFail;
use Tests\TestCase;

/**
 * @covers \Gameap\Http\Controllers\GdaemonAPI\ServersTasksController
 */
class ServersTasksControllerTest extends TestCase
{
    /** @var ServersTasksController */
    protected $controller;

    /** @var ServerTask */
    protected $serverTask;

    /** @var DedicatedServer */
    protected $dedicatedServer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->dedicatedServer = factory(DedicatedServer::class)->create();
        $server = factory(Server::class)->create([
            'ds_id' => $this->dedicatedServer->id,
        ]);
        $this->serverTask = factory(ServerTask::class)->create([
            'server_id' => $server,
        ]);
        $this->controller = $this->createPartialMock(ServersTasksController::class, []);
    }

    public function testGetList()
    {
        $tasksList = $this->controller->getList($this->dedicatedServer);

        $this->assertCount(1, $tasksList);
        $this->assertEquals($this->serverTask->attributesToArray(), $tasksList[0]->attributesToArray());
    }

    public function testFail()
    {
        $request = ServerTaskFailRequest::create(
            '/gdaemon_api/servers_tasks',
            ServerTaskUpdateRequest::METHOD_PUT,
            [
                'output'        => 'Test Output\n Exited code 1',
            ]
        );

        $this->controller->fail($request, $this->serverTask);

        $serverTaskFail = ServerTaskFail::where('server_task_id', $this->serverTask->id)->first();
        $this->assertEquals('Test Output\n Exited code 1', $serverTaskFail->output);
    }

    public function testUpdate()
    {
        $executeDate = date('Y-m-d H:i:s');
        $request = ServerTaskUpdateRequest::create(
            '/gdaemon_api/servers_tasks',
            ServerTaskUpdateRequest::METHOD_PUT,
            [
                'repeat'        => 200,
                'repeat_period' => 600,
                'execute_date'  => $executeDate,
            ]
        );

        $this->controller->update($request, $this->serverTask);
        $serverTask = ServerTask::find($this->serverTask->id);

        $this->assertEquals(200, $serverTask->repeat);
        $this->assertEquals(600, $serverTask->repeat_period);
        $this->assertEquals($executeDate, $serverTask->execute_date);
    }
}
