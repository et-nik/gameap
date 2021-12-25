<?php

namespace Tests\Feature;

use Gameap\Models\Server;
use Gameap\Models\User;
use Gameap\Repositories\UserRepository;
use Silber\Bouncer\Bouncer;
use Tests\TestCase;
use Illuminate\Http\Response;

class ServersPermissionsTest extends TestCase
{
    /** @var User */
    protected $user;

    /** @var Server */
    protected $server;

    /** @var UserRepository */
    protected $userRepository;

    /** @var Bouncer */
    protected $bouncer;

    public function setUp(): void
    {
        parent::setUp();

        $this->server = factory(Server::class)->create();
        $this->user = factory(User::class)->create();

        $this->bouncer = $this->app->get(Bouncer::class);

        $this->bouncer->sync($this->user)->roles(['user']);
        $this->bouncer->refresh();

        $this->userRepository = new UserRepository($this->bouncer);

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
