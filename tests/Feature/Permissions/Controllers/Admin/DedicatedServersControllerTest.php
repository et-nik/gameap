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

    public function testAllowIndex()
    {
        Bouncer::sync($this->user)->roles(['admin']);

        $response = $this->get(route('admin.dedicated_servers.index'));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.dedicated_servers.list');
    }

    public function testAllowShow()
    {
        Bouncer::sync($this->user)->roles(['admin']);

        $response = $this->get(route('admin.dedicated_servers.show', 1));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.dedicated_servers.view');
    }

    public function testAllowEdit()
    {
        Bouncer::sync($this->user)->roles(['admin']);

        $response = $this->get(route('admin.dedicated_servers.edit', 1));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.dedicated_servers.edit');
    }

    public function testForbiddenIndex()
    {
        Bouncer::sync($this->user)->roles(['admin']);
        Bouncer::sync($this->user)->forbiddenAbilities(['admin roles & permissions']);

        $response = $this->get(route('admin.dedicated_servers.index'));

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testForbiddenShow()
    {
        Bouncer::sync($this->user)->roles(['admin']);
        Bouncer::sync($this->user)->forbiddenAbilities(['admin roles & permissions']);

        $response = $this->get(route('admin.dedicated_servers.show', 1));

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testForbiddenEdit()
    {
        Bouncer::sync($this->user)->roles(['admin']);
        Bouncer::sync($this->user)->forbiddenAbilities(['admin roles & permissions']);

        $response = $this->get(route('admin.dedicated_servers.edit', 1));

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testForbiddenUserIndex()
    {
        Bouncer::sync($this->user)->roles(['user']);

        $response = $this->get(route('admin.dedicated_servers.index'));

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testForbiddenUserShow()
    {
        Bouncer::sync($this->user)->roles(['user']);

        $response = $this->get(route('admin.dedicated_servers.show', 1));

        $response->assertStatus(Response::HTTP_FORBIDDEN);

    }

    public function testForbiddenUserEdit()
    {
        Bouncer::sync($this->user)->roles(['user']);

        $response = $this->get(route('admin.dedicated_servers.edit', 1));

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
