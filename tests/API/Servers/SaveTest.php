<?php

namespace Tests\API\Servers;

use Gameap\Models\Server;
use Gameap\Models\User;
use Silber\Bouncer\Bouncer;
use Symfony\Component\HttpFoundation\Response;
use Tests\API\APITestCase;

class SaveTest extends APITestCase
{
    /** @var \Silber\Bouncer\Bouncer */
    protected $bouncer;

    public function setUp(): void
    {
        parent::setUp();

        $this->bouncer = $this->app->get(Bouncer::class);
        $this->bouncer->dontCache();
    }

    public function testSaveServer_Success()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $this->bouncer->sync($user)->roles(['admin']);
        $node = $this->givenNode();
        $server = factory(Server::class)->create([
            'ds_id' => $node->id,
        ]);
        $gameMod = $this->givenGameMod();

        $response = $this->put(
            '/api/servers/'.$server->id,
            [
                'ds_id' => $node->id,
                'installed' => 1,
                'name' => "updated server name" . $server->name,
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

        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('servers', [
            'name'              => "updated server name" . $server->name,
            'game_id'           => $gameMod->game_code,
            'game_mod_id'       => $gameMod->id,
            'ds_id'             => $node->id,
            'installed'         => 1,
            'server_ip'         => array_first($node->ip),
            'server_port'       => 13777,
            'query_port'        => 13777,
            'rcon_port'         => 13777,
            'rcon'              => 'password',
            'start_command'     => './start_command',
            'dir'               => 'servers/dir'
        ]);
    }

    public function testSaveServer_Forbidden()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $node = $this->givenNode();
        $server = factory(Server::class)->create([
            'ds_id' => $node->id,
        ]);
        $gameMod = $this->givenGameMod();

        $response = $this->put(
            '/api/servers/'.$server->id,
            [
                'ds_id' => $node->id,
                'installed' => 1,
                'name' => "updated server name" . $server->name,
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

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
