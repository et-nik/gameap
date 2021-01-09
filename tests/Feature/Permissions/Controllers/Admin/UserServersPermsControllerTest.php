<?php

namespace Tests\Feature\Permissions\Controllers\Admin;

use Bouncer;
use Gameap\Models\Server;
use Gameap\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

/**
 * @covers \Gameap\Http\Controllers\Admin\UsersServersPermsController
 */
class UserServersPermsControllerTest extends TestCase
{
    /** @var User */
    protected $user;

    /** @var Server */
    protected $server;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->be($this->user);

        $this->server = factory(Server::class)->create();
    }

    public function testAllowEditServerPermission(): void
    {
        Bouncer::sync($this->user)->roles(['admin']);
        Bouncer::sync($this->user)->abilities(['admin roles & permissions']);

        $response = $this->get(route('admin.users.edit_server_permissions', [$this->user, $this->server]));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.users.server_perms.edit');
    }

    public function testForbiddenEditServerPermission(): void
    {
        Bouncer::sync($this->user)->roles(['admin']);
        Bouncer::sync($this->user)->forbiddenAbilities(['admin roles & permissions']);

        $response = $this->get(route('admin.users.edit_server_permissions', [$this->user, $this->server]));

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
