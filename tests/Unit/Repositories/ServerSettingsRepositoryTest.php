<?php

namespace Tests\Unit\Repositories;

use Gameap\Models\DedicatedServer;
use Gameap\Models\Server;
use Gameap\Models\ServerSetting;
use Gameap\Repositories\ServerSettingsRepository;
use Tests\TestCase;

class ServerSettingsRepositoryTest extends TestCase
{
    public function testSaveSettings(): void
    {
        /**
         * @var DedicatedServer $dedicatedServer
         * @var Server $server
         */
        $dedicatedServer = factory(DedicatedServer::class)->create();
        $server = factory(Server::class)->create([
            'ds_id' => $dedicatedServer->id,
        ]);
        $repository = new ServerSettingsRepository();

        $repository->saveSettings($server, [
            ['name' => 'setting', 'value' => 'val']
        ]);

        $this->assertDatabaseHas('servers_settings', [
            'server_id' => $server->id,
            'name' => 'setting',
            'value' => 'val'
        ]);
    }

    public function testSaveSettings_existsSettingRemoved(): void
    {
        /**
         * @var DedicatedServer $dedicatedServer
         * @var Server $server
         * @var ServerSetting $serverSetting
         */
        $dedicatedServer = factory(DedicatedServer::class)->create();
        $server = factory(Server::class)->create([
            'ds_id' => $dedicatedServer->id,
        ]);
        $serverSetting = factory(ServerSetting::class)->create([
            'server_id' => $server->id,
        ]);
        $repository = new ServerSettingsRepository();

        $repository->saveSettings($server, [
            ['name' => 'setting', 'value' => 'val']
        ]);

        $this->assertDatabaseHas('servers_settings', [
            'server_id' => $server->id,
            'name' => 'setting',
            'value' => 'val'
        ]);
        $this->assertDatabaseMissing('servers_settings', [
            'server_id' => $server->id,
            'name' => $serverSetting->name,
            'value' => $serverSetting->value
        ]);
    }

    public function testSaveSettings_replaceSettingValue(): void
    {
        /**
         * @var DedicatedServer $dedicatedServer
         * @var Server $server
         * @var ServerSetting $serverSetting
         */
        $dedicatedServer = factory(DedicatedServer::class)->create();
        $server = factory(Server::class)->create([
            'ds_id' => $dedicatedServer->id,
        ]);
        $serverSetting = factory(ServerSetting::class)->create([
            'server_id' => $server->id,
        ]);
        $repository = new ServerSettingsRepository();

        $repository->saveSettings($server, [
            ['name' => $serverSetting->name, 'value' => 'new_value']
        ]);

        $this->assertDatabaseHas('servers_settings', [
            'server_id' => $server->id,
            'name' => $serverSetting->name,
            'value' => 'new_value'
        ]);
    }

    public function testSaveSettings_invalidSettingsIgnored(): void
    {
        /**
         * @var DedicatedServer $dedicatedServer
         * @var Server $server
         */
        $dedicatedServer = factory(DedicatedServer::class)->create();
        $server = factory(Server::class)->create([
            'ds_id' => $dedicatedServer->id,
        ]);
        $repository = new ServerSettingsRepository();

        $repository->saveSettings($server, [
            ['name' => 'valid_name', 'value' => 'valid_value'],
            ['name' => 'has_no_value'],
            ['value' => 'has_no_name'],
        ]);

        $this->assertDatabaseHas('servers_settings', [
            'server_id' => $server->id,
            'name' => 'valid_name',
            'value' => 'valid_value'
        ]);
        $this->assertDatabaseMissing('servers_settings', [
            'server_id' => $server->id,
            'name' => 'has_no_value',
        ]);
        $this->assertDatabaseMissing('servers_settings', [
            'server_id' => $server->id,
            'value' => 'has_no_name',
        ]);
    }
}
