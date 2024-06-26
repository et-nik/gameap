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
            ['get', 'api.users.servers', ['id' => $this->editedUser->id]],
            ['get', 'api.users.show', ['id' => $this->editedUser->id]],
            ['put', 'api.users.update', ['id' => $this->editedUser->id]],
            ['delete', 'api.users.destroy', ['id' => $this->editedUser->id]],
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
        // I hate f**king PHP. routesDataProvider gives me null in params
        // I wish time to rewrite this to Golang
        $params = ['id' => $this->editedUser->id];

        $this->setCurrentUserRoles(['user']);

        $response = $this->{$method}(route($route, $params), []);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}