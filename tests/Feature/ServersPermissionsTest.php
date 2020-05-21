<?php

namespace Tests\Feature;

use Bouncer;
use Gameap\Models\Server;
use Gameap\Models\User;
use Gameap\Repositories\UserRepository;
use Illuminate\Support\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;

class ServersPermissionsTest extends TestCase
{
    /** @var User */
    protected $user;

    /** @var Server */
    protected $server;

    /** @var UserRepository */
    protected $userRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->server = factory(Server::class)->create();
        $this->user = factory(User::class)->create();

        $this->userRepository = new UserRepository($this->user);

        Bouncer::sync($this->user)->roles(['user']);
        Bouncer::refresh();

        $this->be($this->user);
    }

    public function testCommonAllow()
    {
        $this->userRepository->updateServerPermission($this->user, $this->server, []);

        $response = $this->get(route('servers.control', $this->server->id));
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testCommonForbidden()
    {
        $this->userRepository->updateServerPermission($this->user, $this->server, [
            'game-server-common' => 'disallow',
        ]);

        $response = $this->get(route('servers.control', $this->server->id));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array
     */
    public function twoTrueDataProvider()
    {
        return [
            ['first' => true, 'second' => true],
            ['first' => true, 'second' => false],
            ['first' => false, 'second' => true],
        ];
    }
}
