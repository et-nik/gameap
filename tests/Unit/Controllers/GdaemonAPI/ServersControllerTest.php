<?php

namespace Tests\Unit\Controllers\GdaemonAPI;

use Gameap\Http\Controllers\GdaemonAPI\ServersController;
use Gameap\Http\Requests\GdaemonAPI\JsonServerBulkRequest;
use Gameap\Http\Requests\GdaemonAPI\ServerRequest;
use Gameap\Models\DedicatedServer;
use Gameap\Models\Server;
use Illuminate\Container\Container;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ServersControllerTest extends TestCase
{
    /** @var DedicatedServer */
    protected $dedicatedServer;

    /** @var Server */
    protected $server;

    /** @var Container */
    protected $container;

    protected function setUp(): void
    {
        parent::setUp();

        $this->dedicatedServer = factory(DedicatedServer::class)->create();

        $this->server = factory(Server::class)->create([
            'ds_id' => $this->dedicatedServer->id,
        ]);

        $this->container = Container::getInstance();
    }

    public function testIndexSuccess(): void
    {
        /** @var ServersController $controller */
        $controller = $this->container->make(ServersController::class);

        $result = $controller->index($this->dedicatedServer);

        $this->assertEquals(Response::HTTP_OK, $result->status());
        $this->assertNotEmpty($result->content());
        $content = json_decode($result->content(), true);
        $this->assertCount(1, $content);
        $this->assertSame($this->server->id, $content[0]['id']);
        $this->assertSame($this->server->name, $content[0]['name']);
        $this->assertArrayHasKey('game', $content[0]);
        $this->assertSame($this->server->game->code, $content[0]['game']['code']);
        $this->assertSame($this->server->game->name, $content[0]['game']['name']);
        $this->assertSame($this->server->game->engine, $content[0]['game']['engine']);
        $this->assertArrayHasKey('game_mod', $content[0]);
        $this->assertSame($this->server->gameMod->id, $content[0]['game_mod']['id']);
        $this->assertSame($this->server->gameMod->name, $content[0]['game_mod']['name']);
        $this->assertSame($this->server->gameMod->game_code, $content[0]['game_mod']['game_code']);
        $this->assertArrayHasKey('settings', $content[0]);
    }

    public function testServerSuccess(): void
    {
        /** @var ServersController $controller */
        $controller = $this->container->make(ServersController::class);

        $result = $controller->server($this->server);

        $this->assertEquals(Response::HTTP_OK, $result->status());
        $content = json_decode($result->content(), true);
        $this->assertSame($this->server->id, $content['id']);
        $this->assertSame($this->server->name, $content['name']);
        $this->assertArrayHasKey('game', $content);
        $this->assertSame($this->server->game->code, $content['game']['code']);
        $this->assertSame($this->server->game->name, $content['game']['name']);
        $this->assertSame($this->server->game->engine, $content['game']['engine']);
        $this->assertArrayHasKey('game_mod', $content);
        $this->assertSame($this->server->gameMod->id, $content['game_mod']['id']);
        $this->assertSame($this->server->gameMod->name, $content['game_mod']['name']);
        $this->assertSame($this->server->gameMod->game_code, $content['game_mod']['game_code']);
        $this->assertArrayHasKey('settings', $content);
    }

    public function testUpdateSuccess(): void
    {
        /** @var ServersController $controller */
        $controller = $this->container->make(ServersController::class);
        $request = new ServerRequest([
            'installed' => 2,
            'process_active' => 0,
            'last_process_check' => '2006-01-02 15:04:05',
        ]);

        $result = $controller->update($request, $this->server);

        $this->assertEquals(Response::HTTP_OK, $result->status());
        $this->assertDatabaseHas('servers', [
            'id' => $this->server->id,
            'installed' => 2,
            'process_active' => 0,
            'last_process_check' => '2006-01-02 15:04:05'
        ]);
    }

    public function testUpdateBulk(): void
    {
        /** @var ServersController $controller */
        $controller = $this->container->make(ServersController::class);
        $request = new JsonServerBulkRequest([
            [
                'id' => $this->server->id,
                'installed' => 2,
                'process_active' => 0,
                'last_process_check' => '2006-01-02 15:04:05',
            ]
        ]);

        $result = $controller->updateBulk($request);

        $this->assertEquals(Response::HTTP_OK, $result->status());
        $this->assertDatabaseHas('servers', [
            'id' => $this->server->id,
            'installed' => 2,
            'process_active' => 0,
            'last_process_check' => '2006-01-02 15:04:05'
        ]);
    }
}
