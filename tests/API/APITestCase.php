<?php

namespace Tests\API;

use Gameap\Models\DedicatedServer;
use Gameap\Models\Game;
use Gameap\Models\GameMod;
use Gameap\Models\Server;
use Illuminate\Container\Container;
use Tests\TestCase;

class APITestCase extends TestCase
{
    /** @var Container */
    protected $container;

    protected function setUp(): void
    {
        parent::setUp();

        $this->container = Container::getInstance();
    }

    protected function givenNode(): DedicatedServer
    {
        return factory(DedicatedServer::class)->create();
    }

    protected function givenGameServer(int $nodeId): Server
    {
        return factory(Server::class)->create([
            'ds_id' => $nodeId,
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
