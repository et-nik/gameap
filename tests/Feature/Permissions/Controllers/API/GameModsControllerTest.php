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