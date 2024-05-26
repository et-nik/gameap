<?php

namespace Tests\Feature\Permissions\Controllers\API;

use Gameap\Models\Game;
use Illuminate\Http\Response;
use Tests\Feature\Permissions\PermissionsTestCase;

class GamesControllerTest extends PermissionsTestCase
{
    /** @var Game */
    private $game;

    public function setUp(): void
    {
        parent::setUp();

        $this->game = factory(Game::class)->create();
    }

    public function routesDataProvider()
    {
        return [
            ['get', 'api.games', []],
            ['post', 'api.games.store', []],
            ['get', 'api.games.show', ['game' => $this->game->code]],
            ['put', 'api.games.update', ['game' => $this->game->code]],
            ['post', 'api.games.upgrade', []],
            ['get', 'api.games.mods', ['game' => $this->game->code]],
            ['delete', 'api.games.destroy', ['game' => $this->game->code]],
        ];
    }

    public function testForbidden()
    {
        $this->setCurrentUserRoles(['user']);

        $data = $this->routesDataProvider();

        // dataProvider doesn't work how I expect
        // I don't want to spend a lot of time to find why it doesn't work
        // I rewrite to Golang code faster than found why it doesn't work
        // I hate PHP and PHPUnit
        foreach ($data as $item) {
            $method = $item[0];
            $route = $item[1];
            $params = $item[2] ?? [];

            $response = $this->{$method}(route($route, $params), $data);
            $response->assertStatus(Response::HTTP_FORBIDDEN);
        }
    }
}