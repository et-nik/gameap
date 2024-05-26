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
            ['get', 'api.users'],
            ['post', 'api.users.store'],
            ['get', 'api.users.servers'],
            ['get', 'api.users.show', ['id' => $this->editedUser->id]],
            ['put', 'api.users.update', ['id' => $this->editedUser->id]],
            ['delete', 'api.users.destroy', ['id' => $this->editedUser->id]],
        ];
    }

    /**
     * @dataProvider routesDataProvider
     */
    public function testForbidden($method, $route, $params = [], $data = [])
    {
        $this->setCurrentUserRoles(['user']);

        $response = $this->{$method}(route($route, $params), $data);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}