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

    /** @var \Silber\Bouncer\Bouncer */
    protected $bouncer;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->be($this->user);

        $this->bouncer = $this->app->get(\Silber\Bouncer\Bouncer::class);
    }

    public function testAllowIndex()
    {
        $this->bouncer->sync($this->user)->roles(['admin']);
        $this->bouncer->refresh();

        $response = $this->get(route('admin.dedicated_servers.index'));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.dedicated_servers.list');
    }

    public function testAllowShow()
    {
        $this->bouncer->sync($this->user)->roles(['admin']);
        $this->bouncer->refresh();

        $response = $this->get(route('admin.dedicated_servers.show', 1));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.dedicated_servers.view');
    }

    public function testAllowEdit()
    {
        $this->bouncer->sync($this->user)->roles(['admin']);
        $this->bouncer->refresh();

        $response = $this->get(route('admin.dedicated_servers.edit', 1));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.dedicated_servers.edit');
    }

    public function testAllowDownloadLogs()
    {
        $this->bouncer->sync($this->user)->roles(['admin']);
        $this->bouncer->refresh();

        $response = $this->get(route('admin.dedicated_servers.download_logs', 1));

        $response->assertRedirect(route('admin.dedicated_servers.show', 1));
    }

    public function testAllowDownloadCertificates()
    {
        $this->bouncer->sync($this->user)->roles(['admin']);
        $this->bouncer->refresh();

        $response = $this->get(route('admin.dedicated_servers.download_certificates', 1));

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testForbiddenIndex()
    {
        $this->bouncer->sync($this->user)->roles(['admin']);
        $this->bouncer->sync($this->user)->forbiddenAbilities(['admin roles & permissions']);
        $this->bouncer->refresh();

        $response = $this->get(route('admin.dedicated_servers.index'));

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testForbiddenShow()
    {
        $this->bouncer->sync($this->user)->roles(['admin']);
        $this->bouncer->sync($this->user)->forbiddenAbilities(['admin roles & permissions']);
        $this->bouncer->refresh();

        $response = $this->get(route('admin.dedicated_servers.show', 1));

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testForbiddenEdit()
    {
        $this->bouncer->sync($this->user)->roles(['admin']);
        $this->bouncer->sync($this->user)->forbiddenAbilities(['admin roles & permissions']);
        $this->bouncer->refresh();

        $response = $this->get(route('admin.dedicated_servers.edit', 1));

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testForbiddenUserIndex()
    {
        $this->bouncer->sync($this->user)->roles(['user']);
        $this->bouncer->refresh();

        $response = $this->get(route('admin.dedicated_servers.index'));

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testForbiddenUserShow()
    {
        $this->bouncer->sync($this->user)->roles(['user']);
        $this->bouncer->refresh();

        $response = $this->get(route('admin.dedicated_servers.show', 1));

        $response->assertStatus(Response::HTTP_FORBIDDEN);

    }

    public function testForbiddenUserEdit()
    {
        $this->bouncer->sync($this->user)->roles(['user']);
        $this->bouncer->refresh();

        $response = $this->get(route('admin.dedicated_servers.edit', 1));

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testForbiddenUserDownloadLogs()
    {
        $this->bouncer->sync($this->user)->roles(['user']);
        $this->bouncer->refresh();

        $response = $this->get(route('admin.dedicated_servers.download_logs', 1));

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testForbiddenUserDownloadCertificates()
    {
        $this->bouncer->sync($this->user)->roles(['user']);
        $this->bouncer->refresh();

        $response = $this->get(route('admin.dedicated_servers.download_certificates', 1));

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
