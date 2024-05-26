<?php

namespace Tests\Feature\Permissions\Controllers\API;

use Gameap\Models\GameMod;
use Illuminate\Http\Response;
use Tests\Feature\Permissions\PermissionsTestCase;

class GameModsControllerTest extends PermissionsTestCase
{
    /** @var GameMod */
    private $gameMod;

    public function setUp(): void
    {
        parent::setUp();

        $this->gameMod = factory(GameMod::class)->create();
    }

    public function routesDataProvider()
    {
        return [
            ['get', 'api.game_mods', []],
            ['get', 'api.game_mods.get_mods_list', ['game' => $this->gameMod->game_code]],
            ['post', 'api.game_mods.store', []],
            ['get', 'api.game_mods.show', ['game_mod' => $this->gameMod->id]],
            ['put', 'api.game_mods.update', ['game_mod' => $this->gameMod->id]],
            ['delete', 'api.game_mods.destroy', ['game_mod' => $this->gameMod->id]],
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