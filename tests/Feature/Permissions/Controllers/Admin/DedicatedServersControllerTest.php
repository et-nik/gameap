<?php

namespace Tests\Feature\Permissions\Controllers\Admin;

use Bouncer;
use Gameap\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

/** @covers \Gameap\Http\Controllers\Admin\DedicatedServersController */
class DedicatedServersControllerTest extends TestCase
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
        $response = $this->get(route('admin.dedicated_servers.index'));
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.dedicated_servers.list');

        // Show
        $response = $this->get(route('admin.dedicated_servers.show', 1));
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.dedicated_servers.view');

        // Edit
        $response = $this->get(route('admin.dedicated_servers.edit', 1));
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.dedicated_servers.edit');
    }

    public function testForbidden()
    {
        Bouncer::sync($this->user)->roles(['admin']);
        Bouncer::sync($this->user)->forbiddenAbilities(['admin roles & permissions']);

        // Index
        $response = $this->get(route('admin.dedicated_servers.index'));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // Show
        $response = $this->get(route('admin.dedicated_servers.show', 1));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // Edit
        $response = $this->get(route('admin.dedicated_servers.edit', 1));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testForbiddenUser()
    {
        Bouncer::sync($this->user)->roles(['user']);

        // Index
        $response = $this->get(route('admin.dedicated_servers.index'));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // Show
        $response = $this->get(route('admin.dedicated_servers.show', 1));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // Edit
        $response = $this->get(route('admin.dedicated_servers.edit', 1));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}