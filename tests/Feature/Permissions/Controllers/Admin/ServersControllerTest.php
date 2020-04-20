<?php

namespace Tests\Feature\Permissions\Controllers\Admin;

use Bouncer;
use Gameap\Models\Server;
use Gameap\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

/** @covers \Gameap\Http\Controllers\Admin\ServersController */
class ServersControllerTest extends TestCase
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
        $response = $this->get(route('admin.servers.index'));
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.servers.list');

        // Create
        $response = $this->get(route('admin.servers.create'));
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.servers.create');

        // Store
        $response = $this->post(route('admin.servers.store'), [
            'enabled'               => 1,
            'installed'             => 1,
            'blocked'               => 0,
            'name'                  => 'Test Server',
            'uuid'                  => '6e1a7f10-4bc8-4101-bdcb-e61174a6c3cf',
            'uuid_short'            => '6e1a7f10',
            'game_id'               => 'cstrike',
            'ds_id'                 => 1,
            'game_mod_id'           => 1,
            'expires'               => '2030-01-01',
            'server_ip'             => '127.0.0.2',
            'server_port'           => 29000,
            'query_port'            => 29000,
            'rcon_port'             => 29000,
            'rcon'                  => 'rcon',
            'dir'                   => 'servers/6e1a7f10-4bc8-4101-bdcb-e61174a6c3cf',
            'su_user'               => 'gameap',
            'process_active'        => false,
            'last_process_check'    => date('Y-m-d H:i:s', time()),
            'vars'                  => '[]',
        ]);
        $response->assertStatus(Response::HTTP_FOUND);

        $server = factory(Server::class)->create();

        // Edit
        $response = $this->get(route('admin.servers.edit', $server->id));
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.servers.edit');

        // Update
        $response = $this->put(route('admin.servers.update', $server->id), [
                'name' => $server->name . ' [Secutity Test Updated]'
        ]);
        $response->assertStatus(Response::HTTP_FOUND);

        // Destroy
        $response = $this->delete(route('admin.servers.destroy', $server->id));
        $response->assertStatus(Response::HTTP_FOUND);
    }

    public function testForbidden()
    {
        Bouncer::sync($this->user)->roles(['admin']);
        Bouncer::sync($this->user)->forbiddenAbilities(['admin roles & permissions']);

        // Index
        $response = $this->get(route('admin.servers.index'));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // Create
        $response = $this->get(route('admin.servers.create'));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // Store
        $response = $this->post(route('admin.servers.store'), [
            'enabled'               => 1,
            'installed'             => 1,
            'blocked'               => 0,
            'name'                  => 'Test Server',
            'uuid'                  => 'bc8b0e5a-972d-4331-bdc2-255e2410c11a',
            'uuid_short'            => 'bc8b0e5a',
            'game_id'               => 'cstrike',
            'ds_id'                 => 1,
            'game_mod_id'           => 1,
            'expires'               => '2030-01-01',
            'server_ip'             => '127.0.0.2',
            'server_port'           => 29001,
            'query_port'            => 29001,
            'rcon_port'             => 29001,
            'rcon'                  => 'rcon',
            'dir'                   => 'servers/bc8b0e5a-972d-4331-bdc2-255e2410c11a',
            'su_user'               => 'gameap',
            'process_active'        => false,
            'last_process_check'    => date('Y-m-d H:i:s', time()),
            'vars'                  => '[]',
        ]);
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $server = factory(Server::class)->create();

        // Edit
        $response = $this->get(route('admin.servers.edit', $server->id));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // Update
        $response = $this->put(route('admin.servers.update', $server->id), [
            'name' => $server->name . ' [FORBIDDEN TEST]'
        ]);
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // Destroy
        $response = $this->delete(route('admin.servers.destroy', $server->id));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testForbiddenUser()
    {
        Bouncer::sync($this->user)->roles(['user']);

        // Index
        $response = $this->get(route('admin.servers.index'));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // Create
        $response = $this->get(route('admin.servers.create'));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // Store
        $response = $this->post(route('admin.servers.store'), [
            'enabled'               => 1,
            'installed'             => 1,
            'blocked'               => 0,
            'name'                  => 'Test Server',
            'uuid'                  => '7a214760-655b-4d2e-b34f-47ae0414f1c1',
            'uuid_short'            => '7a214760',
            'game_id'               => 'cstrike',
            'ds_id'                 => 1,
            'game_mod_id'           => 1,
            'expires'               => '2030-01-01',
            'server_ip'             => '127.0.0.2',
            'server_port'           => 29002,
            'query_port'            => 29002,
            'rcon_port'             => 29002,
            'rcon'                  => 'rcon',
            'dir'                   => 'servers/7a214760-655b-4d2e-b34f-47ae0414f1c1',
            'su_user'               => 'gameap',
            'process_active'        => false,
            'last_process_check'    => date('Y-m-d H:i:s', time()),
            'vars'                  => '[]',
        ]);
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $server = factory(Server::class)->create();

        // Edit
        $response = $this->get(route('admin.servers.edit', $server->id));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // Update
        $response = $this->put(route('admin.servers.update', $server->id), [
            'name' => $server->name . ' [FORBIDDEN TEST]'
        ]);
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // Destroy
        $response = $this->delete(route('admin.servers.destroy', $server->id));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}