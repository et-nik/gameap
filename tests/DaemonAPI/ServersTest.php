<?php

namespace Tests\DaemonAPI;

use Symfony\Component\HttpFoundation\Response;

class ServersTest extends TestCase
{
    public function testServersLinuxNode_Success()
    {
        $node = $this->givenLinuxNode();
        $server = $this->givenGameServer($node->id);

        $response = $this->get(
            '/gdaemon_api/servers',
            [
                'X-Auth-Token' => $node->gdaemon_api_token,
                'Accept' => 'application/json',
            ]
        );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonPath('0.id', $server->id);
        $response->assertJsonPath('0.uuid', $server->uuid);
        $response->assertJsonPath('0.uuid_short', $server->uuid_short);
        $response->assertJsonPath('0.enabled', $server->enabled);
        $response->assertJsonPath('0.installed', $server->installed);
        $response->assertJsonPath('0.blocked', $server->blocked);
        $response->assertJsonPath('0.name', $server->name);
        $response->assertJsonPath('0.game_id', $server->game_id);
        $response->assertJsonPath('0.ds_id', $server->ds_id);
        $response->assertJsonPath('0.game_mod_id', $server->game_mod_id);
        $response->assertJsonPath('0.server_ip', $server->server_ip);
        $response->assertJsonPath('0.server_port', $server->server_port);
        $response->assertJsonPath('0.rcon_port', $server->rcon_port);
        $response->assertJsonPath('0.rcon', $server->rcon);
        $response->assertJsonPath('0.dir', $server->dir);
        $response->assertJsonPath('0.su_user', $server->su_user);
        $response->assertJsonPath('0.cpu_limit', $server->cpu_limit);
        $response->assertJsonPath('0.ram_limit', $server->ram_limit);
        $response->assertJsonPath('0.net_limit', $server->net_limit);
        $response->assertJsonPath('0.start_command', $server->start_command);
        $response->assertJsonPath('0.game.code', $server->game->code);
        $response->assertJsonPath('0.game.start_code', $server->game->start_code);
        $response->assertJsonPath('0.game.steam_app_id', $server->game->steam_app_id_linux);
        $response->assertJsonPath('0.game.remote_repository', $server->game->remote_repository_linux);
        $response->assertJsonPath('0.game.local_repository', $server->game->local_repository_linux);
        $response->assertJsonPath('0.game_mod.id', $server->gameMod->id);
        $response->assertJsonPath('0.game_mod.name', $server->gameMod->name);
        $response->assertJsonPath('0.game_mod.remote_repository', $server->gameMod->remote_repository_linux);
        $response->assertJsonPath('0.game_mod.local_repository', $server->gameMod->local_repository_linux);
        $response->assertJsonPath('0.game_mod.default_start_cmd', $server->gameMod->start_cmd_linux);
        $response->assertJsonPath('0.game_mod.default_start_cmd_linux', $server->gameMod->start_cmd_linux);
        $response->assertJsonPath('0.game_mod.default_start_cmd_windows', $server->gameMod->start_cmd_windows);
    }

    public function testServersWindowsNode_Success()
    {
        $node = $this->givenWindowsNode();
        $server = $this->givenGameServer($node->id);

        $response = $this->get(
            '/gdaemon_api/servers',
            [
                'X-Auth-Token' => $node->gdaemon_api_token,
                'Accept' => 'application/json',
            ]
        );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonPath('0.id', $server->id);
        $response->assertJsonPath('0.uuid', $server->uuid);
        $response->assertJsonPath('0.uuid_short', $server->uuid_short);
        $response->assertJsonPath('0.enabled', $server->enabled);
        $response->assertJsonPath('0.installed', $server->installed);
        $response->assertJsonPath('0.blocked', $server->blocked);
        $response->assertJsonPath('0.name', $server->name);
        $response->assertJsonPath('0.game_id', $server->game_id);
        $response->assertJsonPath('0.ds_id', $server->ds_id);
        $response->assertJsonPath('0.game_mod_id', $server->game_mod_id);
        $response->assertJsonPath('0.server_ip', $server->server_ip);
        $response->assertJsonPath('0.server_port', $server->server_port);
        $response->assertJsonPath('0.rcon_port', $server->rcon_port);
        $response->assertJsonPath('0.rcon', $server->rcon);
        $response->assertJsonPath('0.dir', $server->dir);
        $response->assertJsonPath('0.su_user', $server->su_user);
        $response->assertJsonPath('0.cpu_limit', $server->cpu_limit);
        $response->assertJsonPath('0.ram_limit', $server->ram_limit);
        $response->assertJsonPath('0.net_limit', $server->net_limit);
        $response->assertJsonPath('0.start_command', $server->start_command);
        $response->assertJsonPath('0.game.code', $server->game->code);
        $response->assertJsonPath('0.game.start_code', $server->game->start_code);
        $response->assertJsonPath('0.game.steam_app_id', $server->game->steam_app_id_windows);
        $response->assertJsonPath('0.game.remote_repository', $server->game->remote_repository_windows);
        $response->assertJsonPath('0.game.local_repository', $server->game->local_repository_windows);
        $response->assertJsonPath('0.game_mod.id', $server->gameMod->id);
        $response->assertJsonPath('0.game_mod.name', $server->gameMod->name);
        $response->assertJsonPath('0.game_mod.remote_repository', $server->gameMod->remote_repository_windows);
        $response->assertJsonPath('0.game_mod.local_repository', $server->gameMod->local_repository_windows);
        $response->assertJsonPath('0.game_mod.default_start_cmd', $server->gameMod->start_cmd_windows);
        $response->assertJsonPath('0.game_mod.default_start_cmd_linux', $server->gameMod->start_cmd_linux);
        $response->assertJsonPath('0.game_mod.default_start_cmd_windows', $server->gameMod->start_cmd_windows);
    }

    public function testServersIdLinux_Success()
    {
        $node = $this->givenNode();
        $server = $this->givenGameServer($node->id);

        $response = $this->get(
            '/gdaemon_api/servers/' . $server->id,
            [
                'X-Auth-Token' => $node->gdaemon_api_token,
                'Accept' => 'application/json',
            ]
        );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonPath('id', $server->id);
        $response->assertJsonPath('uuid', $server->uuid);
        $response->assertJsonPath('uuid_short', $server->uuid_short);
        $response->assertJsonPath('enabled', $server->enabled);
        $response->assertJsonPath('installed', $server->installed);
        $response->assertJsonPath('blocked', $server->blocked);
        $response->assertJsonPath('name', $server->name);
        $response->assertJsonPath('game_id', $server->game_id);
        $response->assertJsonPath('ds_id', $server->ds_id);
        $response->assertJsonPath('game_mod_id', $server->game_mod_id);
        $response->assertJsonPath('server_ip', $server->server_ip);
        $response->assertJsonPath('server_port', $server->server_port);
        $response->assertJsonPath('rcon_port', $server->rcon_port);
        $response->assertJsonPath('rcon', $server->rcon);
        $response->assertJsonPath('dir', $server->dir);
        $response->assertJsonPath('su_user', $server->su_user);
        $response->assertJsonPath('cpu_limit', $server->cpu_limit);
        $response->assertJsonPath('ram_limit', $server->ram_limit);
        $response->assertJsonPath('net_limit', $server->net_limit);
        $response->assertJsonPath('start_command', $server->start_command);
        $response->assertJsonPath('game.code', $server->game->code);
        $response->assertJsonPath('game.start_code', $server->game->start_code);
        $response->assertJsonPath('game.steam_app_id', $server->game->steam_app_id_linux);
        $response->assertJsonPath('game.remote_repository', $server->game->remote_repository_linux);
        $response->assertJsonPath('game.local_repository', $server->game->local_repository_linux);
        $response->assertJsonPath('game_mod.id', $server->gameMod->id);
        $response->assertJsonPath('game_mod.name', $server->gameMod->name);
        $response->assertJsonPath('game_mod.remote_repository', $server->gameMod->remote_repository_linux);
        $response->assertJsonPath('game_mod.local_repository', $server->gameMod->local_repository_linux);
        $response->assertJsonPath('game_mod.default_start_cmd', $server->gameMod->start_cmd_linux);
        $response->assertJsonPath('game_mod.default_start_cmd_linux', $server->gameMod->start_cmd_linux);
        $response->assertJsonPath('game_mod.default_start_cmd_windows', $server->gameMod->start_cmd_windows);
    }

    public function testServersIdWindows_Success()
    {
        $node = $this->givenWindowsNode();
        $server = $this->givenGameServer($node->id);

        $response = $this->get(
            '/gdaemon_api/servers/' . $server->id,
            [
                'X-Auth-Token' => $node->gdaemon_api_token,
                'Accept' => 'application/json',
            ]
        );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonPath('id', $server->id);
        $response->assertJsonPath('uuid', $server->uuid);
        $response->assertJsonPath('uuid_short', $server->uuid_short);
        $response->assertJsonPath('enabled', $server->enabled);
        $response->assertJsonPath('installed', $server->installed);
        $response->assertJsonPath('blocked', $server->blocked);
        $response->assertJsonPath('name', $server->name);
        $response->assertJsonPath('game_id', $server->game_id);
        $response->assertJsonPath('ds_id', $server->ds_id);
        $response->assertJsonPath('game_mod_id', $server->game_mod_id);
        $response->assertJsonPath('server_ip', $server->server_ip);
        $response->assertJsonPath('server_port', $server->server_port);
        $response->assertJsonPath('rcon_port', $server->rcon_port);
        $response->assertJsonPath('rcon', $server->rcon);
        $response->assertJsonPath('dir', $server->dir);
        $response->assertJsonPath('su_user', $server->su_user);
        $response->assertJsonPath('cpu_limit', $server->cpu_limit);
        $response->assertJsonPath('ram_limit', $server->ram_limit);
        $response->assertJsonPath('net_limit', $server->net_limit);
        $response->assertJsonPath('start_command', $server->start_command);
        $response->assertJsonPath('game.code', $server->game->code);
        $response->assertJsonPath('game.start_code', $server->game->start_code);
        $response->assertJsonPath('game.steam_app_id', $server->game->steam_app_id_windows);
        $response->assertJsonPath('game.remote_repository', $server->game->remote_repository_windows);
        $response->assertJsonPath('game.local_repository', $server->game->local_repository_windows);
        $response->assertJsonPath('game_mod.id', $server->gameMod->id);
        $response->assertJsonPath('game_mod.name', $server->gameMod->name);
        $response->assertJsonPath('game_mod.remote_repository', $server->gameMod->remote_repository_windows);
        $response->assertJsonPath('game_mod.local_repository', $server->gameMod->local_repository_windows);
        $response->assertJsonPath('game_mod.default_start_cmd', $server->gameMod->start_cmd_windows);
        $response->assertJsonPath('game_mod.default_start_cmd_linux', $server->gameMod->start_cmd_linux);
        $response->assertJsonPath('game_mod.default_start_cmd_windows', $server->gameMod->start_cmd_windows);
    }

    public function testServers_InvalidToken()
    {
        $response = $this->get(
            '/gdaemon_api/servers/',
            [
                'X-Auth-Token' => 'invalid',
                'Accept' => 'application/json',
            ]
        );

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $response->assertJsonPath('message', 'Invalid api token');
    }

    public function testServersId_InvalidToken()
    {
        $node = $this->givenNode();
        $server = $this->givenGameServer($node->id);

        $response = $this->get(
            '/gdaemon_api/servers/' . $server->id,
            [
                'X-Auth-Token' => 'invalid',
                'Accept' => 'application/json',
            ]
        );

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $response->assertJsonPath('message', 'Invalid api token');
    }

    public function testUpdateServer_Success()
    {
        $node = $this->givenNode();
        $server = $this->givenGameServer($node->id);

        $response = $this->put(
            '/gdaemon_api/servers/' . $server->id,
            [
                'installed' => 1,
                'process_active' => 1,
                'last_process_check' => '1971-11-19 22:52:16'
            ],
            [
                'X-Auth-Token' => $node->gdaemon_api_token,
                'Accept' => 'application/json',
            ]
        );

        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('servers', [
            'id' => $server->id,
            'installed' => 1,
            'process_active' => 1,
            'last_process_check' => '1971-11-19 22:52:16',
        ]);
    }
}
