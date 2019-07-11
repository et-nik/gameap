<?php


namespace Tests\Unit\Models;

use Gameap\Models\Game;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class GameTest extends TestCase
{
    public function testServers()
    {
        $game = Game::where(['code' => 'valve'])->first();
        $this->assertInstanceOf(Collection::class, $game->servers);
    }

    public function testMods()
    {
        $game = Game::where(['code' => 'valve'])->first();
        $this->assertInstanceOf(Collection::class, $game->mods);
    }
}