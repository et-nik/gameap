<?php

namespace Tests\Context\Browser\Models;

use Gameap\Models\Game;

trait GameContextTrait
{
    private function givenGame(): Game
    {
        $game = factory(Game::class)->create([
            'code'              => 'test',
            'name'              => 'Test',
            'remote_repository' => 'https://files.gameap.ru/test/test.tar.xz',
        ]);

        return $game;
    }
}
