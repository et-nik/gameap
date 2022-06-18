<?php

namespace Tests\Context\Browser\Models;

use Gameap\Models\GameMod;

trait GameModContextTrait
{
    private function givenGameMod(): GameMod
    {
        return factory(GameMod::class)->create([
            'game_code'               => 'test',
            'name'                    => 'Test Game Mod',
            'remote_repository_linux' => '',
        ]);
    }
}
