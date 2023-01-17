<?php

namespace Tests\API\Admin\Servers;

use Gameap\Models\User;
use Silber\Bouncer\Bouncer;
use Symfony\Component\HttpFoundation\Response;
use Tests\API\APITestCase;

class CreateTest extends APITestCase
{
    /** @var \Silber\Bouncer\Bouncer */
    protected $bouncer;

    public function setUp(): void
    {
        parent::setUp();

        $this->bouncer = $this->app->get(Bouncer::class);
        $this->bouncer->dontCache();
    }

    public function testCreateServer_ExpectInstallationGDaemonTaskExists()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $this->bouncer->sync($user)->roles(['admin']);
        $node = $this->givenNode();
        $gameMod = $this->givenGameMod();

        $response = $this->post(
            '/admin/servers',
            [
                'ds_id' => $node->id,
                'install' => 1,
                'name' => __FUNCTION__,
                'game_id' => $gameMod->game_code,
                'game_mod_id' => $gameMod->id,
                'server_ip' => array_first($node->ip),
                'server_port' => 13777,
                'query_port' => 13777,
                'rcon_port' => 13777,
                'rcon'      => 'password',
                'start_command' => './start_command',
                'dir' => 'servers/dir',
            ]
        );

        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertDatabaseHas('servers', [
            'name'              => __FUNCTION__,
            'game_id'           => $gameMod->game_code,
            'game_mod_id'       => $gameMod->id,
            'ds_id'             => $node->id,
            'installed'         => 0,
            'server_ip'         => array_first($node->ip),
            'server_port'       => 13777,
            'query_port'        => 13777,
            'rcon_port'         => 13777,
            'rcon'              => 'password',
            'start_command'     => './start_command',
            'dir'               => 'servers/dir'
        ]);
        $this->assertDatabaseHas('gdaemon_tasks', [
            'dedicated_server_id'   => $node->id,
            'task'                  => 'gsinst',
            'status'                => 'waiting',
        ]);
    }

    public function testCreateServerUncheckedInstallServer_ExpectInstallationGDaemonTaskDoesNotExists()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $this->bouncer->sync($user)->roles(['admin']);
        $node = $this->givenNode();
        $gameMod = $this->givenGameMod();

        $response = $this->post(
            '/admin/servers',
            [
                'ds_id' => $node->id,
                'name' => __FUNCTION__,
                'game_id' => $gameMod->game_code,
                'game_mod_id' => $gameMod->id,
                'server_ip' => array_first($node->ip),
                'server_port' => 13777,
                'query_port' => 13777,
                'rcon_port' => 13777,
                'rcon'      => 'password',
                'dir' => sprintf('%s/servers/dir', $node->work_path),
            ]
        );

        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertDatabaseHas('servers', [
            'name'              => __FUNCTION__,
            'game_id'           => $gameMod->game_code,
            'game_mod_id'       => $gameMod->id,
            'ds_id'             => $node->id,
            'installed'         => 0,
            'server_ip'         => array_first($node->ip),
            'server_port'       => 13777,
            'query_port'        => 13777,
            'rcon_port'         => 13777,
            'rcon'              => 'password',
            'dir'               => 'servers/dir'
        ]);
        $this->assertDatabaseMissing('gdaemon_tasks', [
            'dedicated_server_id'   => $node->id,
            'task'                  => 'gsinst',
            'status'                => 'waiting',
        ]);
    }

    public function testCreateServerNodeNotExists_ExpectNotFound()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $this->bouncer->sync($user)->roles(['admin']);
        $gameMod = $this->givenGameMod();

        $response = $this->post(
            '/admin/servers',
            [
                'ds_id' => 99999999999999,
                'name' => __FUNCTION__,
                'game_id' => $gameMod->game_code,
                'game_mod_id' => $gameMod->id,
                'server_ip' => '127.0.0.1',
                'server_port' => 13777,
                'query_port' => 13777,
                'rcon_port' => 13777,
                'rcon'      => 'password',
                'dir' => 'servers/dir',
            ]
        );

        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $this->assertDatabaseMissing('servers', [
            'name'              => __FUNCTION__,
            'game_id'           => $gameMod->game_code,
            'game_mod_id'       => $gameMod->id,
            'ds_id'             => 99999999999999,
            'server_ip'         => '127.0.0.1',
            'server_port'       => 13777,
            'query_port'        => 13777,
            'rcon_port'         => 13777,
            'rcon'              => 'password',
            'dir'               => 'servers/dir'
        ]);
    }
}
