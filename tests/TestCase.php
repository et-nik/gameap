<?php

namespace Tests;

use Gameap\Models\DedicatedServer;
use Gameap\Models\Game;
use Gameap\Models\GameMod;
use Gameap\Models\Server;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Database\Seeders\DedicatedServersTableSeeder;
use Database\Seeders\ServersTableSeeder;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public static $initialized = false;

    protected function setUp(): void
    {
        parent::setUp();

        if (! self::$initialized) {
            self::$initialized = true;

            $this->seed(DedicatedServersTableSeeder::class);
            $this->seed(ServersTableSeeder::class);
        }
    }

    protected function givenNode(): DedicatedServer
    {
        return factory(DedicatedServer::class)->create([
            'gdaemon_api_key' => str_random(),
            'gdaemon_api_token' => str_random(),
        ]);
    }

    protected function givenLinuxNode(): DedicatedServer
    {
        return factory(DedicatedServer::class)->create([
            'os' => 'linux',
            'gdaemon_api_key' => str_random(),
            'gdaemon_api_token' => str_random(),
        ]);
    }

    protected function givenWindowsNode(): DedicatedServer
    {
        return factory(DedicatedServer::class)->create([
            'os' => 'windows',
            'gdaemon_api_key' => str_random(),
            'gdaemon_api_token' => str_random(),
        ]);
    }

    protected function givenGameServer(int $nodeId): Server
    {
        $gameMod = $this->givenGameMod();

        return factory(Server::class)->create([
            'ds_id' => $nodeId,
            'game_id' => $gameMod->game_code,
            'game_mod_id' => $gameMod->id,
        ]);
    }

    protected function givenGame(): Game
    {
        return factory(Game::class)->create();
    }

    protected function givenGameMod(): GameMod
    {
        return factory(GameMod::class)->create();
    }
}
