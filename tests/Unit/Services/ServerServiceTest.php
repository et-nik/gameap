<?php

namespace Tests\Unit;

use Gameap\Models\ClientCertificate;
use Gameap\Models\DedicatedServer;
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
    public function adapterProviderGameQ()
    {
        $mockGameQ = Mockery::mock('GameQ\GameQ');
        $mockGameQ->shouldReceive('setOption')->andReturnSelf();
        $mockGameQ->shouldReceive('addServer')->andReturnSelf();

        $mockGdaemon = Mockery::mock('Knik\Gameap\GdaemonCommands');
        $mockGdaemon->shouldReceive('setConfig')->andReturnSelf();
        $mockGdaemon->shouldReceive('disconnect');

        $serverService = new ServerService($mockGameQ, $mockGdaemon);

        $game = new Game();
        $game->engine = 'source';

        $server = new Server();
        $server->game = $game;
        $server->server_ip = '127.0.0.1';
        $server->server_port = 1337;
        $server->query_port = 1337;

        return [
            [$serverService, $mockGameQ, $server],
        ];
    }

    public function testCreateService()
    {
        $mockGameQ = Mockery::mock('GameQ\GameQ');
        $mockGameQ->shouldReceive('setOption')->andReturnSelf();
        $mockGameQ->shouldReceive('addServer')->andReturnSelf();

        $mockGdaemon = Mockery::mock('Knik\Gameap\GdaemonCommands');
        $mockGdaemon->shouldReceive('setConfig')->andReturnSelf();
        $mockGdaemon->shouldReceive('disconnect');

        $serverService = new ServerService($mockGameQ, $mockGdaemon);

        $this->assertInstanceOf('Gameap\Services\ServerService', $serverService);
    }

    /**
     * @dataProvider adapterProviderGameQ
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

    public function adapterProviderGdaemon()
    {
        $clientCertificate = new ClientCertificate();
        $clientCertificate->id = 1;
        $clientCertificate->certificate = 'certificate';
        $clientCertificate->private_key = 'private_key';
        $clientCertificate->private_key_pass = '';

        $dedicatedServer = new DedicatedServer();
        $dedicatedServer->clientCertificate = $clientCertificate;
        $dedicatedServer->work_path = '/srv/servers';
        $dedicatedServer->script_get_console = './script_get_console.sh';

        $server = new Server();
        $server->server_ip = '127.0.0.1';
        $server->server_port = 1337;
        $server->query_port = 1337;
        $server->rcon_port = 1337;
        $server->dir = 'server01';

        $server->dedicatedServer = $dedicatedServer;

        $mockGameQ = Mockery::mock('GameQ\GameQ');
        $mockGdaemon = Mockery::mock('Knik\Gameap\GdaemonCommands');
        $serverService = new ServerService($mockGameQ, $mockGdaemon);

        $mockGdaemon->shouldReceive('setConfig')->andReturnSelf();
        $mockGdaemon->shouldReceive('disconnect');

        return [
            [$serverService, $mockGdaemon, $server],
        ];
    }

    /**
     * @dataProvider adapterProviderGdaemon
     */
    public function testGetConsoleLog($serverService, $mock, $server)
    {
        $mock->shouldReceive('exec')->andReturn("command result");

        $consoleLog = $serverService->getConsoleLog($server);

        $this->assertEquals('command result', $consoleLog);
    }

    /**
     * @dataProvider adapterProviderGdaemon
     *
     * @param ServerService $serverService
     * @param $mock
     * @param Server $server
     */
    public function testGetCommand($serverService, $mock, $server)
    {
        $command = $serverService->getCommand($server, 'get_console');

        $this->assertEquals('./script_get_console.sh', $command);
    }

    /**
     * @dataProvider adapterProviderGdaemon
     *
     * @param ServerService $serverService
     * @param $mock
     * @param Server $server
     */
    public function testReplaceShortCodes($serverService, $mock, $server)
    {
        $extra = ['extra' => 'azaza'];
        $command = $serverService->replaceShortCodes($server, './script.sh {extra}', $extra);
        $this->assertEquals('./script.sh azaza', $command);

        $command = $serverService->replaceShortCodes($server, './script.sh {host} {port}');
        $this->assertEquals('./script.sh 127.0.0.1 1337', $command);

        $server->dedicatedServer->work_path = '/srv/server/';
        $server->dir = '/server01';

        $command = $serverService->replaceShortCodes($server, './script.sh {dir}');
        $this->assertEquals('./script.sh /srv/server/server01', $command);
    }

    /**
     * @dataProvider adapterProviderGdaemon
     *
     * @param ServerService $serverService
     * @param $mock
     * @param Server $server
     *
     * @expectedException \Gameap\Exceptions\Services\InvalidCommand
     */
    public function testGetCommandInvalidCommand($serverService, $mock, $server)
    {
        $serverService->getCommand($server, 'invalid_command');
    }
}