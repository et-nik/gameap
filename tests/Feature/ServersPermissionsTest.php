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
    protected static $user;

    /** @var Server */
    protected $server;

    /** @var UserRepository */
    protected $userRepository;

    public function setUp(): void
    {
        parent::setUp();

        $factoryResult = factory(Server::class, 1)->create();
        $this->server = $factoryResult->first();

        // TODO: Fix Error: Cannot use object of type Illuminate\Support\Facades\Config as array
        // I don’t know how to fix the problem differently. I used a static $user variable.
        // See https://stackoverflow.com/questions/27590818/cannot-use-object-of-type-illuminate-support-facades-config-as-array-in-fram
        if (is_null(self::$user)) {
            $factoryResult = factory(User::class)->create([
                'login' => 'user_permission',
                'email' => 'up@gameap.io',
                'password' => bcrypt("123")
            ]);

            if ($factoryResult instanceof Collection) {
                self::$user = $factoryResult->first();
            } else {
                self::$user = $factoryResult;
            }
        }

        $this->userRepository = new UserRepository(self::$user);

        Bouncer::sync(self::$user)->roles(['user']);
        Bouncer::refresh();

        $this->be(self::$user);
    }

    public function testCommonAllow()
    {
        $this->userRepository->updateServerPermission(self::$user, $this->server, []);

        $response = $this->get(route('servers.control', $this->server->id));
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testCommonForbidden()
    {
        $this->userRepository->updateServerPermission(self::$user, $this->server, [
            'game-server-common' => 'disallow',
        ]);

        $response = $this->get(route('servers.control', $this->server->id));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testFileManagerAllow()
    {
        $this->userRepository->update(self::$user, ['servers' => [$this->server->id]]);
        $this->userRepository->updateServerPermission(self::$user, $this->server, []);

        $response = $this->get(route('servers.filemanager', $this->server->id));
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testFileManagerForbiddenNotRelation()
    {
        $this->userRepository->updateServerPermission(self::$user, $this->server, [
            'game-server-common' => 'disallow',
            'game-server-files' => 'disallow',
        ]);
        $this->userRepository->update(self::$user, []);

        $response = $this->get(route('servers.filemanager', $this->server->id));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return array
     */
    public function twoFalseDataProvider()
    {
        return [
            ['first' => false, 'second' => false],
            ['first' => true, 'second' => false],
            ['first' => false, 'second' => true],
        ];
    }

    /**
     * @dataProvider twoFalseDataProvider
     */
//    public function testFileManagerForbidden(bool $first, bool $second)
//    {
//        $this->userRepository->updateServerPermission(self::$user, $this->server, [
//            'game-server-common' => $first,
//            'game-server-files' => $second,
//        ]);
//
//        $response = $this->get(route('servers.filemanager', $this->server->id));
//        $response->assertStatus(Response::HTTP_FORBIDDEN);
//    }

    public function testSettingsAllow()
    {
        $this->userRepository->update(self::$user, ['servers' => [$this->server->id]]);
        $this->userRepository->updateServerPermission(self::$user, $this->server, []);

        $response = $this->get(route('servers.settings', $this->server->id));
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testSettingsForbidden()
    {
        $this->userRepository->update(self::$user, ['servers' => [$this->server->id]]);
        $this->userRepository->updateServerPermission(self::$user, $this->server, [
            'game-server-common' => 'disallow',
            'game-server-settings' => 'disallow',
        ]);

        $response = $this->get(route('servers.settings', $this->server->id));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
