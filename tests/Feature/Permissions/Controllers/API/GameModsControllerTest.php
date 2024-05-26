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
            ['get', 'api.game_mods'],
            ['get', 'api.game_mods.get_mods_list', $this->gameMod->game_code],
            ['post', 'api.game_mods.store'],
            ['get', 'api.game_mods.show', $this->gameMod->id],
            ['put', 'api.game_mods.update', $this->gameMod->id],
            ['delete', 'api.game_mods.destroy', $this->gameMod->id],
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