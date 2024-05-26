<?php

namespace Tests\Feature\Permissions\Controllers\API;

use Gameap\Models\User;
use Illuminate\Http\Response;
use Tests\Feature\Permissions\PermissionsTestCase;

class UsersControllerTest  extends PermissionsTestCase
{
    /** @var User */
    private $editedUser;

    public function setUp(): void
    {
        parent::setUp();

        $this->editedUser = factory(User::class)->create();
    }

    public function routesDataProvider()
    {
        return [
            ['get', 'api.users', []],
            ['post', 'api.users.store', []],
            ['get', 'api.users.servers', [$this->editedUser->id]],
            ['get', 'api.users.show', [$this->editedUser->id]],
            ['put', 'api.users.update', [$this->editedUser->id]],
            ['delete', 'api.users.destroy', [$this->editedUser->id]],
        ];
    }

    /**
     * @dataProvider routesDataProvider
     *
     * @param string $method
     * @param string $route
     * @param array $params
     */
    public function testForbidden(string $method, string $route, array $params = [])
    {
        $this->setCurrentUserRoles(['user']);

        $response = $this->{$method}(route($route, $params), []);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}