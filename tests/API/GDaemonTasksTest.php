<?php

namespace Tests\API;

use Gameap\Models\GdaemonTask;
use Gameap\Models\User;
use Gameap\Repositories\UserRepository;
use Illuminate\Http\Response;
use Silber\Bouncer\Bouncer;

class GDaemonTasksTest extends APITestCase
{
    /** @var Bouncer */
    private $bouncer;

    /** @var UserRepository */
    private $userRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->bouncer = $this->app->get(Bouncer::class);
        $this->bouncer->dontCache();

        $this->userRepository = $this->app->get(UserRepository::class);
    }

    public function testTaskViewAdmin_Success()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $this->bouncer->sync($user)->roles(['admin']);
        /** @var GdaemonTask $task */
        $task = factory(GdaemonTask::class)->create();

        $response = $this->get('/api/gdaemon_tasks/' . $task->id);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment([
               'id' => $task->id,
               'server_id' => $task->server_id,
               'task' => $task->task,
                'status' => $task->status,
            ]);
    }

    public function testTaskViewUser_Success()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        /** @var GdaemonTask $task */
        $task = factory(GdaemonTask::class)->create();
        $this->userRepository->updateServerPermission($user, $task->server, []);

        $response = $this->get('/api/gdaemon_tasks/' . $task->id);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment([
                'id' => $task->id,
                'server_id' => $task->server_id,
                'task' => $task->task,
                'status' => $task->status,
            ]);
    }

    public function testTaskViewUserWithoutAccess_Forbidden()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        /** @var GdaemonTask $task */
        $task = factory(GdaemonTask::class)->create();

        $response = $this->get('/api/gdaemon_tasks/' . $task->id);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testTaskViewGuest_Unauthorized()
    {
        /** @var GdaemonTask $task */
        $task = factory(GdaemonTask::class)->create();

        $response = $this->get('/api/gdaemon_tasks/' . $task->id, ['Accept' => 'application/json']);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testCommonTaskViewUser_Forbidden()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        /** @var GdaemonTask $task */
        $task = factory(GdaemonTask::class)->create([
            'server_id' => null,
        ]);

        $response = $this->get('/api/gdaemon_tasks/' . $task->id);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testOutputAdmin_Success()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $this->bouncer->sync($user)->roles(['admin']);
        /** @var GdaemonTask $task */
        $task = factory(GdaemonTask::class)->create();

        $response = $this->get('/api/gdaemon_tasks/' . $task->id . '/output');

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testOutputUser_Forbidden()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        /** @var GdaemonTask $task */
        $task = factory(GdaemonTask::class)->create();

        $response = $this->get('/api/gdaemon_tasks/' . $task->id . '/output');

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testOutputUserWithServerAccess_Forbidden()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        /** @var GdaemonTask $task */
        $task = factory(GdaemonTask::class)->create();
        $this->userRepository->updateServerPermission($user, $task->server, []);

        $response = $this->get('/api/gdaemon_tasks/' . $task->id . '/output');

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
