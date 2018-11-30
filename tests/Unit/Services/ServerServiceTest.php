<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use Gameap\Services\ServerService;
use Gameap\Models\Server;
use Gameap\Models\Game;

/**
 * @covers \Gameap\Services\ServerService <extended>
 */
class ServerServiceTest extends TestCase
{
    public function adapterProvider()
    {
        $mock = Mockery::mock('GameQ\GameQ');

        $serverService = new ServerService($mock);

        $mock->shouldReceive('setOption')->andReturnSelf();
        $mock->shouldReceive('addServer')->andReturnSelf();

        $game = new Game();
        $game->engine = 'source';

        $server = new Server();
        $server->game = $game;
        $server->server_ip = '127.0.0.1';
        $server->server_port = 1337;
        $server->query_port = 1337;

        return [
            [$serverService, $mock, $server],
        ];
    }

    /**
     * @dataProvider adapterProvider
     */
    public function testQuery($serverService, $mock, $server)
    {
        $mock->shouldReceive('process')->andReturn([
            "{$server->server_ip}:{$server->query_port}" => [
                'gq_online' => false,
            ]
        ], [
            "{$server->server_ip}:{$server->query_port}" => [
                'gq_online' => true,
                'gq_hostname' => 'test',
                'gq_mapname' => 'mapa',
                'gq_numplayers' => 4,
                'gq_maxplayers' => 32,
                'version' => 'test',
                'gq_password' => false,
                'gq_joinlink' => 'steam://127.0.0.1:1337',
            ]
        ]);

        $query = $serverService->query($server);
        $this->assertEquals(['status' => 'offline'], $query);

        $query = $serverService->query($server);
        $this->assertEquals([
            'status' => 'online',
            'hostname' => 'test',
            'map' => 'mapa',
            'players' => '4/32',
            'version' => 'test',
            'password' => 'no',
            'joinlink' => 'steam://127.0.0.1:1337',
        ], $query);
    }
}