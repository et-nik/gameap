<?php

namespace Tests\Feature\Permissions\Controllers\Admin;

use Bouncer;
use Gameap\Models\Server;
use Gameap\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

/**
 * @covers \Gameap\Http\Controllers\Admin\ServersSettingsController
 */
class ServersSettingsControllerTest extends TestCase
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

    public function testAllowEdit(): void
    {
        Bouncer::sync($this->user)->roles(['admin']);

        $response = $this->get(route('admin.servers_settings.edit', [$this->server]));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.servers_settings.settings');
    }

    public function testForbiddenEdit(): void
    {
        Bouncer::sync($this->user)->roles(['admin']);
        Bouncer::sync($this->user)->forbiddenAbilities(['admin roles & permissions']);

        $response = $this->get(route('admin.servers_settings.edit', [$this->server]));

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
