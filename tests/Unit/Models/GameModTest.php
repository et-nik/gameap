<?php

namespace Tests\Unit\Models;

use Gameap\Models\GameMod;
use Gameap\Models\Game;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class GameModTest extends TestCase
{
    public function testServers()
    {
        $gameMod = GameMod::find(1);
        $this->assertInstanceOf(Collection::class, $gameMod->servers);
    }
    
    public function testGame()
    {
        $gameMod = GameMod::find(1);
        $this->assertInstanceOf(Game::class, $gameMod->game);
        
        $gameMod->vars = null;
        $this->assertIsArray($gameMod->vars);
        $this->assertEquals([], $gameMod->vars);

        $gameMod->vars = ['arr'];
        $this->assertIsArray($gameMod->vars);
        $this->assertEquals(['arr'], $gameMod->vars);

        $gameMod->fast_rcon = null;
        $this->assertIsArray($gameMod->fast_rcon);
    }
}