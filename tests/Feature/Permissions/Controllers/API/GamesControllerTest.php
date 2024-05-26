<?php

namespace Tests\Feature\Permissions\Controllers\API;

use Gameap\Models\Game;
use Illuminate\Http\Response;
use Tests\Feature\Permissions\PermissionsTestCase;

class GamesControllerTest extends PermissionsTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function routesDataProvider()
    {
        /** @var Game $game */
        $game = factory(Game::class)->create();

        return [
            ['get', 'api.games'],
            ['post', 'api.games.store'],
            ['get', 'api.games.show', $game->code],
            ['put', 'api.games.update', $game->code],
            ['post', 'api.games.upgrade'],
            ['get', 'api.games.mods', $game->code],
            ['delete', 'api.games.destroy', $game->code],
        ];
    }

    /**
     * @dataProvider routesDataProvider
     */
    public function testForbidden($method, $route, $param = null, $data = [])
    {
        $this->setCurrentUserRoles(['user']);

        $response = $this->{$method}(route($route, $param), $data);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}