<?php

namespace Tests\Feature\Permissions\Controllers\API;

use Gameap\Models\User;
use Gameap\Repositories\UserRepository;
use Illuminate\Http\Response;
use Silber\Bouncer\Bouncer;
use Tests\TestCase;

class ClientCertificatesControllerTest extends TestCase
{
    /**
     * @var User
     */
    protected $user;

    /** @var UserRepository */
    protected $userRepository;

    /** @var Bouncer */
    protected $bouncer;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->be($this->user);

        $this->bouncer = $this->app->get(Bouncer::class);

        $this->userRepository = new UserRepository($this->bouncer);
    }

    public function routesDataProvider()
    {
        return [
            ['get', 'api.client_certificates.list'],
            ['post', 'api.client_certificates.store'],
            ['delete', 'api.client_certificates.destroy', 1],
        ];
    }

    /**
     * @dataProvider routesDataProvider
     */
    public function testForbidden($method, $route, $param = null, $data = [])
    {
        $this->bouncer->sync($this->user)->roles(['user']);
        $this->bouncer->refresh();

        $response = $this->{$method}(route($route, $param), $data);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}