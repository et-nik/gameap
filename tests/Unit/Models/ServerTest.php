<?php

namespace Tests\Unit\Models;

use Carbon\Carbon;
use Gameap\Models\DedicatedServer;
use Gameap\Models\Game;
use Gameap\Models\GameMod;
use Gameap\Models\ServerSetting;
use Gameap\Models\Server;
use Illuminate\Database\Eloquent\Collection;
use PHPUnit\Framework\Assert;
use Tests\TestCase;

class ServerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        factory(Server::class, 1)->create();
    }

    public function testProcessActive_emptyLastProcessCheck(): void
    {
        $server = new Server();

        $result = $server->processActive();

        Assert::assertFalse($result);
    }

    public function testProcessActive_active(): void
    {
        $server = new Server();
        $server->last_process_check = Carbon::now('UTC')->toDateTimeString();
        $server->process_active = true;

        $result = $server->processActive();

        Assert::assertTrue($result);
    }

    public function testProcessActive_inactive(): void
    {
        $server = new Server();
        $server->last_process_check = Carbon::now('UTC')->toDateTimeString();
        $server->process_active = false;

        $result = $server->processActive();

        Assert::assertFalse($result);
    }

    public function testProcessActive_lastProcessCheckOverdue(): void
    {
        $server = new Server();
        $server->last_process_check = Carbon::createFromTimestamp(0)->utc()->toDateTimeString();
        $server->process_active = true;

        $result = $server->processActive();

        Assert::assertFalse($result);
    }

    public function testGetFullPathAttribute()
    {
        $server = new Server();
        $server->dedicatedServer = new DedicatedServer();
        
        $server->dedicatedServer->work_path = '/ds/work/path';
        $server->dir = 'servers';

        Assert::assertEquals('/ds/work/path/servers', $server->fullPath);
    }
    
    public function testGetFileManagerDisksAttribute()
    {
        $server = Server::first();
        ServerSetting::firstOrCreate([
            'name' => 'file-manager',
            'server_id' => $server->id,
            'value' => json_encode(['custom' => ['test' => 'test']]),
        ])->save();

        Assert::assertIsArray($server->fileManagerDisks);
        Assert::assertArrayHasKey('server', $server->fileManagerDisks);
        Assert::assertArrayHasKey('custom', $server->fileManagerDisks);
    }

    public function testGetAliasesAttribute_existValue(): void
    {
        $gameMod = factory(GameMod::class)->create([
            'vars' => [
                [
                    'var'       => 'example',
                    'default'   => 'def_value',
                    'info'      => 'Example value',
                    'admin_var' => false,
                ],
            ],
        ]);
        $server = factory(Server::class)->create([
            'game_id'       => $gameMod->game_code,
            'game_mod_id'   => $gameMod->id,
            'vars'          => [],
        ]);

        $vars = $server->vars;
        $vars['example'] = 'var-value';
        $server->vars = $vars;

        Assert::assertIsArray($server->aliases);
        Assert::assertArrayHasKey('ip', $server->aliases);
        Assert::assertArrayHasKey('port', $server->aliases);
        Assert::assertArrayHasKey('query_port', $server->aliases);
        Assert::assertArrayHasKey('rcon_port', $server->aliases);
        Assert::assertArrayHasKey('uuid', $server->aliases);
        Assert::assertArrayHasKey('uuid_short', $server->aliases);
        Assert::assertEquals('var-value', $server->aliases['example']);
    }

    public function testGetAliasesAttribute_defaultValue()
    {
        $gameMod = factory(GameMod::class)->create([
            'vars' => [
                [
                    'var'       => 'example',
                    'default'   => 'def_value',
                    'info'      => 'Example value',
                    'admin_var' => false,
                ],
            ],
        ]);
        $server = factory(Server::class)->create([
            'game_id'       => $gameMod->game_code,
            'game_mod_id'   => $gameMod->id,
        ]);

        Assert::assertEquals('def_value', $server->aliases['example']);
    }
}
