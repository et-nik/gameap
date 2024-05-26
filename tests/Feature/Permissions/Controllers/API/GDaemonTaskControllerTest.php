<?php

namespace Tests\Feature\Permissions\Controllers\API;

use Gameap\Models\GdaemonTask;
use Illuminate\Http\Response;
use Tests\Feature\Permissions\PermissionsTestCase;

class GDaemonTaskControllerTest extends PermissionsTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function routesDataProvider()
    {
        /** @var GdaemonTask $task */
        $task = factory(GdaemonTask::class)->create();

        return [
            ['get', 'api.gdaemon_tasks.list'],
            ['get', 'api.gdaemon_tasks.get', $task->id],
            ['get', 'api.gdaemon_tasks.output', $task->id],
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
}