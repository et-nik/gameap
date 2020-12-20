<?php

namespace Tests\Services\Unit;

use Carbon\Carbon;
use GameQ\GameQ;
use Gameap\Exceptions\Services\InvalidCommandException;
use Gameap\Exceptions\Services\ServerInactiveException;
use Gameap\Models\ClientCertificate;
use Gameap\Models\DedicatedServer;
use Gameap\Models\Game;
use Gameap\Models\Server;
use Gameap\Services\ServerService;
use Knik\Gameap\GdaemonCommands;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\Assert;
use Tests\TestCase;

/** @covers \Gameap\Services\ServerService */
class ServerServiceTest extends TestCase
{
    public function adapterProviderGameQ(): array
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

    public function testCreateService(): void
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
     * @param ServerService $serverService
     * @param GameQ|MockInterface $mock
     * @param Server $server
     * @throws \Exception
     */
    public function testQuery(ServerService $serverService, $mock, Server $server): void
    {
        $host = "{$server->server_ip}:{$server->query_port}";
        $mock->shouldReceive('process')->andReturn([
            $host => [
                'gq_online' => false,
            ]
        ], [
            $host => [
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

    /**
     * @dataProvider adapterProviderGameQ
     * @param ServerService $serverService
     * @param GameQ|MockInterface $mock
     * @param Server $server
     * @throws \Exception
     */
    public function testQueryInvalid(ServerService $serverService, $mock, Server $server): void
    {
        $mock->shouldReceive('process')->andReturn([
            '1.3.3.7:27015' => [
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
    }

    /**
     * @return array[]
     */
    public function adapterProviderGdaemon(): array
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
        $dedicatedServer->script_send_command = './script_send_command.sh {command}';

        $server = new Server();
        $server->server_ip = '127.0.0.1';
        $server->server_port = 1337;
        $server->query_port = 1337;
        $server->rcon_port = 1337;
        $server->dir = 'server01';
        $server->last_process_check = Carbon::now('UTC')->toDateTimeString();
        $server->process_active = true;

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
     * @param ServerService $serverService
     * @param GdaemonCommands|MockInterface $mock
     * @param Server $server
     */
    public function testGetConsoleLog(ServerService $serverService, $mock, Server $server): void
    {
        $mock->shouldReceive('exec')->andReturn("command result");

        $consoleLog = $serverService->getConsoleLog($server);

        $this->assertEquals('command result', $consoleLog);
    }

    /**
     * @dataProvider adapterProviderGdaemon
     *
     * @param $serverService
     * @param $mock
     * @param $server
     *
     */
    public function testGetConsoleLogInactiveServer(ServerService $serverService, $mock, $server): void
    {
        $this->expectException(ServerInactiveException::class);
        $server->process_active = false;

        $mock->shouldReceive('exec')->andReturn("command result");

        $serverService->getConsoleLog($server);
    }

    /**
     * @dataProvider adapterProviderGdaemon
     * @param $serverService
     * @param $mock
     * @param $server
     */
    public function testSendConsoleCommand(ServerService $serverService, $mock, $server): void
    {
        $mock->shouldReceive('exec')
            ->andReturnUsing(function($command, &$exitCode) {
                $exitCode = 0;
                return "command result";
        });
        $exitCode = null;

        $result = $serverService->sendConsoleCommand($server, 'ban knik');

        Assert::assertTrue($result);
    }

    /**
     * @dataProvider adapterProviderGdaemon
     */
    public function testSendConsoleCommandFail(ServerService $serverService, $gdaemonMock, $server): void
    {
        $gdaemonMock->shouldReceive('exec')
            ->andReturnUsing(function($command, &$exitCode) {
                $exitCode = 1;
                return "command result";
            });
        $exitCode = null;

        $result = $serverService->sendConsoleCommand($server, 'ban knik');

        Assert::assertFalse($result);
    }

    /**
     * @dataProvider adapterProviderGdaemon
     * @param $serverService
     * @param $mock
     * @param $server
     */
    public function testSendConsoleCommandInactive(ServerService $serverService, $mock, $server)
    {
        $this->expectException(ServerInactiveException::class);
        $server->process_active = false;
        $mock->shouldReceive('exec')->andReturn("command result");
        $serverService->sendConsoleCommand($server, 'ban knik');
    }

    /**
     * @dataProvider adapterProviderGdaemon
     *
     * @param ServerService $serverService
     * @param $mock
     * @param Server $server
     *
     * @throws \Gameap\Exceptions\Services\EmptyCommandException
     * @throws InvalidCommandException
     */
    public function testGetCommand(ServerService $serverService, $mock, $server)
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
    public function testReplaceShortCodes(ServerService $serverService, $mock, $server)
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
     * @throws \Gameap\Exceptions\Services\EmptyCommandException
     * @throws InvalidCommandException
     */
    public function testGetCommandInvalidCommand(ServerService $serverService, $mock, $server)
    {
        $this->expectException(InvalidCommandException::class);
        $serverService->getCommand($server, 'invalid_command');
    }
}
