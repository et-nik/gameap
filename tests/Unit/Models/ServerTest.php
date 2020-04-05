<?php

namespace Tests\Unit\Models;

use Gameap\Models\DedicatedServer;
use Gameap\Models\Game;
use Gameap\Models\GameMod;
use Gameap\Models\ServerSetting;
use Gameap\Models\Server;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class ServerTest extends TestCase
{
    public function testProcessActive()
    {
        factory(Server::class, 100)->create();
        $server = Server::first();
        
        $this->assertIsBool($server->processActive());
        
        $server->last_process_check = null;
        $this->assertFalse($server->processActive());
        
        $server->last_process_check = date('Y-m-d H:i:s', time());
        $server->process_active = true;
        $this->assertTrue($server->processActive());

        $server->last_process_check = date('Y-m-d H:i:s', 0);
        $server->process_active = true;
        $this->assertFalse($server->processActive());
    }
    
    public function testDedicatedServer()
    {
        $server = Server::first();
        $this->assertInstanceOf(DedicatedServer::class, $server->dedicatedServer);
    }

    public function testGame()
    {
        $server = Server::first();
        $this->assertInstanceOf(Game::class, $server->game);
    }

    public function testGameMod()
    {
        $server = Server::first();
        $this->assertInstanceOf(GameMod::class, $server->gameMod);
    }
    
    public function testSettings()
    {
        $server = Server::first();
        $this->assertInstanceOf(Collection::class, $server->settings);
    }
    
    public function testUsers()
    {
        $server = Server::first();
        $this->assertInstanceOf(Collection::class, $server->users);
    }
    
    public function testGetFullPathAttribute()
    {
        $server = Server::first();
        
        $server->dedicatedServer->work_path = '/ds/work/path';
        $server->dir = 'servers';
        
        $this->assertEquals('/ds/work/path/servers', $server->fullPath);
    }
    
    public function testGetFileManagerDisksAttribute()
    {
        $server = Server::first();

        $this->assertIsArray($server->fileManagerDisks);
        $this->assertArrayHasKey('server', $server->fileManagerDisks);

        ServerSetting::firstOrCreate([
            'name' => 'file-manager',
            'server_id' => $server->id,
            'value' => json_encode(['custom' => ['test' => 'test']]),
        ])->save();
        
        $this->assertArrayHasKey('custom', $server->fileManagerDisks);
    }
    
    public function testGetAliasesAttribute()
    {
        $gameMod = factory(GameMod::class)->create([
            'vars' => [
                [
                    'var'       => 'example',
                    'default'   => 'def_value',
                    'info'      => 'Example value',
                    'admin_var' => false,
                ]
            ],
        ]);

        $server = factory(Server::class)->create([
            'game_id'       => $gameMod->game_code,
            'game_mod_id'   => $gameMod->id,
        ]);

        $this->assertIsArray($server->aliases);
        $this->arrayHasKey('ip', $server->aliases);
        $this->arrayHasKey('port', $server->aliases);
        $this->arrayHasKey('query_port', $server->aliases);
        $this->arrayHasKey('rcon_port', $server->aliases);
        $this->arrayHasKey('uuid', $server->aliases);
        $this->arrayHasKey('short_uuid', $server->aliases);

        $alias = $server->gameMod->vars[array_rand($server->gameMod->vars)];
        $aliasVarName = $alias['var'];
        
        $vars = $server->vars;
        $vars[$aliasVarName] = 'var-value';
        $server->vars = $vars;
        $server->save();
        
        $this->assertArrayHasKey($aliasVarName, $server->aliases);
        $this->assertEquals('var-value', $server->aliases[$aliasVarName]);
        
        // Default value
        
        $aliasVarDefault = $alias['default'];
        $vars = $server->vars;
        unset($vars[$aliasVarName]);
        $server->vars = $vars;
        $server->save();

        $this->assertArrayHasKey($aliasVarName, $server->aliases);
        $this->assertEquals($aliasVarDefault, $server->aliases[$aliasVarName]);
    }
}