<?php

namespace Tests\Context\Browser\Models;

use Gameap\Models\Game;

trait GameContextTrait
{
    private function givenGame(): Game
    {
        $game = factory(Game::class)->create([
            'code'         => 'test',
            'name'         => 'Test',
        ]);

        return $game;
    }
}
