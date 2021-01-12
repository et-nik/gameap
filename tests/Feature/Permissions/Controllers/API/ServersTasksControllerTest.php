<?php

namespace Tests\Feature\Permissions\Controllers\API;

use Gameap\Models\GameMod;
use Gameap\Models\Server;
use Gameap\Models\ServerTask;
use Gameap\Models\User;
use Gameap\Repositories\UserRepository;
use Illuminate\Http\Response;
use Tests\TestCase;
use Bouncer;

/**
 * @covers \Gameap\Http\Controllers\WebAPI\ServersTasksController
 */
class ServersTasksControllerTest extends TestCase
{
    /**
     * @var User
     */
    protected $user;

    /** @var UserRepository */
    protected $userRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->be($this->user);

        $this->userRepository = new UserRepository($this->user);
    }

    public function testForbidden()
    {
        Bouncer::sync($this->user)->roles(['user']);
        Bouncer::refresh();

        /** @var Server $server */
        $server = factory(Server::class)->create();
        $this->userRepository->updateServerPermission($this->user, $server, [
            'game-server-tasks' => 'disallow'
        ]);

        // getList
        $response = $this->get(route('api.servers.get_tasks', $server->id));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // store
        $response = $this->post(route('api.servers.add_task', $server->id), [
            'server_id'     => $server->id,
            'command'       => 'start',
            'repeat'        => '0',
            'repeat_period' => '1 day',
            'execute_date'  => '2020-05-23 00:00:00',
        ]);
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        /** @var ServerTask $task */
        $task = factory(ServerTask::class)->create();

        // update
        $response = $this->put(route('api.servers.update_task', [$server->id, $task->id]), [
            'command'       => 'start',
            'repeat'        => '0',
            'repeat_period' => '1 day',
            'execute_date'  => '2020-05-23 00:00:00',
        ]);
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // destroy
        $response = $this->delete(route('api.servers.delete_task', [$server->id, $task->id]));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testAllow()
    {
        Bouncer::sync($this->user)->roles(['user']);
        Bouncer::refresh();

        /** @var Server $server */
        $server = factory(Server::class)->create();
        $this->userRepository->updateServerPermission($this->user, $server, []);

        $this->user->allow('server-tasks', $server);
        $this->user->allow('server-start', $server);

        // getList
        $response = $this->get(route('api.servers.get_tasks', $server->id));
        $response->assertStatus(Response::HTTP_OK);

        // store
        $response = $this->post(route('api.servers.add_task', $server->id), [
            'server_id'     => $server->id,
            'command'       => 'start',
            'repeat'        => '0',
            'repeat_period' => '1 day',
            'execute_date'  => '2020-05-23 00:00:00',
        ]);
        $response->assertStatus(Response::HTTP_CREATED);

        /** @var ServerTask $task */
        $task = factory(ServerTask::class)->create();

        // update
        $response = $this->put(route('api.servers.update_task', [$server->id, $task->id]), [
            'command'       => 'start',
            'repeat'        => '0',
            'repeat_period' => '1 day',
            'execute_date'  => '2020-05-23 00:00:00',
        ]);
        $response->assertStatus(Response::HTTP_OK);

        // destroy
        $response = $this->delete(route('api.servers.delete_task', [$server->id, $task->id]));
        $response->assertStatus(Response::HTTP_OK);
    }

    public function forbiddenCommandsDataprovider()
    {
        return [
            ['command' => 'start', 'ability' => 'server-start'],
            ['command' => 'stop', 'ability' => 'server-stop'],
            ['command' => 'restart', 'ability' => 'server-restart'],
            ['command' => 'update', 'ability' => 'server-update'],
        ];
    }

    /**
     * @dataProvider forbiddenCommandsDataprovider
     */
    public function testForbiddenCommands($command, $ability)
    {
        Bouncer::sync($this->user)->roles(['user']);
        Bouncer::refresh();

        /** @var Server $server */
        $server = factory(Server::class)->create();

        $this->user->allow('server-tasks', $server);

        $this->user->allow('server-start', $server);
        $this->user->allow('server-stop', $server);
        $this->user->allow('server-restart', $server);
        $this->user->allow('server-update', $server);

        $this->user->forbid($ability, $server);

        // store
        $response = $this->post(route('api.servers.add_task', $server->id), [
            'server_id'     => $server->id,
            'command'       => $command,
            'repeat'        => '0',
            'repeat_period' => '1 day',
            'execute_date'  => '2020-05-23 00:00:00',
        ]);
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        /** @var ServerTask $task */
        $task = factory(ServerTask::class)->create();

        // update
        $response = $this->put(route('api.servers.update_task', [$server->id, $task->id]), [
            'command'       => $command,
            'repeat'        => '0',
            'repeat_period' => '1 day',
            'execute_date'  => '2020-05-23 00:00:00',
        ]);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testAllowAdmin()
    {
        Bouncer::sync($this->user)->roles(['admin']);
        Bouncer::refresh();

        /** @var Server $server */
        $server = factory(Server::class)->create();

        // getList
        $response = $this->get(route('api.servers.get_tasks', $server->id));
        $response->assertStatus(Response::HTTP_OK);

        // store
        $response = $this->post(route('api.servers.add_task', $server->id), [
            'server_id'     => $server->id,
            'command'       => 'start',
            'repeat'        => '0',
            'repeat_period' => '1 day',
            'execute_date'  => '2020-05-23 00:00:00',
        ]);
        $response->assertStatus(Response::HTTP_CREATED);

        /** @var ServerTask $task */
        $task = factory(ServerTask::class)->create();

        // update
        $response = $this->put(route('api.servers.update_task', [$server->id, $task->id]), [
            'command'       => 'start',
            'repeat'        => '0',
            'repeat_period' => '1 day',
            'execute_date'  => '2020-05-23 00:00:00',
        ]);
        $response->assertStatus(Response::HTTP_OK);

        // destroy
        $response = $this->delete(route('api.servers.delete_task', [$server->id, $task->id]));
        $response->assertStatus(Response::HTTP_OK);
    }
}
