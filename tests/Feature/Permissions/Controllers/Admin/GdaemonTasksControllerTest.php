<?php

namespace Tests\Feature\Permissions\Controllers\Admin;

use Bouncer;
use Gameap\Models\GdaemonTask;
use Gameap\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

/** @covers \Gameap\Http\Controllers\Admin\GdaemonTasksController */
class GdaemonTasksControllerTest extends TestCase
{
    /**
     * @var User
     */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->be($this->user);
    }

    public function testAllow()
    {
        Bouncer::sync($this->user)->roles(['admin']);

        // Index
        $response = $this->get(route('admin.gdaemon_tasks.index'));
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.gdaemon_tasks.list');

        $gdaemonTask = factory(GdaemonTask::class)->create();

        // Show
        $response = $this->get(route('admin.gdaemon_tasks.show', ['gdaemon_task' => $gdaemonTask->id]));
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.gdaemon_tasks.view');

        // Cancel
        $response = $this->post(route('admin.gdaemon_tasks.cancel', ['gdaemon_task' => $gdaemonTask->id]));
        $response->assertStatus(Response::HTTP_FOUND);
    }

    public function testForbidden()
    {
        Bouncer::sync($this->user)->roles(['admin']);
        Bouncer::sync($this->user)->forbiddenAbilities(['admin roles & permissions']);

        // Index
        $response = $this->get(route('admin.gdaemon_tasks.index'));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $gdaemonTask = factory(GdaemonTask::class)->create();

        // Show
        $response = $this->get(route('admin.gdaemon_tasks.show', ['gdaemon_task' => $gdaemonTask->id]));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // Cancel
        $response = $this->post(route('admin.gdaemon_tasks.cancel', ['gdaemon_task' => $gdaemonTask->id]));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testForbiddenUser()
    {
        Bouncer::sync($this->user)->roles(['user']);

        // Index
        $response = $this->get(route('admin.gdaemon_tasks.index'));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $gdaemonTask = factory(GdaemonTask::class)->create();

        // Show
        $response = $this->get(route('admin.gdaemon_tasks.show', ['gdaemon_task' => $gdaemonTask->id]));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // Cancel
        $response = $this->post(route('admin.gdaemon_tasks.cancel', ['gdaemon_task' => $gdaemonTask->id]));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}