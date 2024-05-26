<?php

namespace Tests\Feature\Permissions\Controllers\API;

use Gameap\Models\GdaemonTask;
use Illuminate\Http\Response;
use Tests\Feature\Permissions\PermissionsTestCase;

class GDaemonTaskControllerTest extends PermissionsTestCase
{
    /** @var GdaemonTask */
    private $task;

    public function setUp(): void
    {
        parent::setUp();

        $this->task = factory(GdaemonTask::class)->create();
    }

    public function routesDataProvider()
    {
        return [
            ['get', 'api.gdaemon_tasks.list', []],
            ['get', 'api.gdaemon_tasks.get', ['gdaemon_task' => $this->task->id]],
            ['get', 'api.gdaemon_tasks.output', ['gdaemon_task' => $this->task->id]],
        ];
    }

    public function testForbidden()
    {
        $this->setCurrentUserRoles(['user']);

        $data = $this->routesDataProvider();

        // dataProvider doesn't work how I expect
        // I don't want to spend a lot of time to find why it doesn't work
        // I rewrite to Golang code faster than found why it doesn't work
        // I hate PHP and PHPUnit
        foreach ($data as $item) {
            $method = $item[0];
            $route = $item[1];
            $params = $item[2] ?? [];

            $response = $this->{$method}(route($route, $params), $data);
            $response->assertStatus(Response::HTTP_FORBIDDEN);
        }
    }
}