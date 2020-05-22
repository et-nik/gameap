<?php

namespace Tests\Feature\Permissions\Controllers\API;

use Gameap\Models\GameMod;
use Gameap\Models\Server;
use Gameap\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;
use Bouncer;

/**
 * @covers \Gameap\Http\Controllers\API\ServersRconController
 */
class ServerRconControllerTest extends TestCase
{
    /**
     * @var User
     */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->be($this->user);
    }

    public function testForbidden()
    {
        Bouncer::sync($this->user)->roles(['user']);

        $server = factory(Server::class)->create([
            'game_id' => 'cstrike',
            'game_mod_id' => GameMod::select('id')->where(['game_code' => 'cstrike'])->first(),
            'process_active' => false,
        ]);

        // sendCommand
        $response = $this->post(route('api.server.rcon', $server->id), ['command' => 'test']);
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // getPlayers
        $response = $this->get(route('api.server.rcon.players', $server->id));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // message
        $response = $this->post(route('api.server.rcon.players.message', $server->id), ['message' => 'test']);
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // kick
        $response = $this->post(route('api.server.rcon.players.kick', $server->id), [
            'player'    => 1,
            'reason'    => 'test',
        ]);
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // ban
        $response = $this->post(route('api.server.rcon.players.ban', $server->id), [
            'player'    => 1,
            'reason'    => 'test',
            'time'      => 0,
        ]);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testAllow()
    {
        Bouncer::sync($this->user)->roles(['user']);

        $server = factory(Server::class)->create([
            'game_id' => 'cstrike',
            'game_mod_id' => GameMod::select('id')->where(['game_code' => 'cstrike'])->first(),
            'process_active' => false,
        ]);

        $this->user->allow('server-rcon-console', $server);
        $this->user->allow('server-rcon-players', $server);

        // sendCommand
        $response = $this->post(route('api.server.rcon', $server->id), ['command' => 'test']);
        $response->assertStatus(Response::HTTP_OK);

        // getPlayers
        $response = $this->get(route('api.server.rcon.players', $server->id));
        $response->assertStatus(Response::HTTP_OK);

        // message
        $response = $this->post(route('api.server.rcon.players.message', $server->id), ['message' => 'test']);
        $response->assertStatus(Response::HTTP_OK);

        // kick
        $response = $this->post(route('api.server.rcon.players.kick', $server->id), [
            'player'    => 1,
            'reason'    => 'test',
        ]);
        $response->assertStatus(Response::HTTP_OK);

        // ban
        $response = $this->post(route('api.server.rcon.players.ban', $server->id), [
            'player'    => 1,
            'reason'    => 'test',
            'time'      => 0,
        ]);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testAllowAdmin()
    {
        Bouncer::sync($this->user)->roles(['admin']);

        $server = factory(Server::class)->create([
            'game_id' => 'cstrike',
            'game_mod_id' => GameMod::select('id')->where(['game_code' => 'cstrike'])->first(),
            'process_active' => false,
        ]);

        // sendCommand
        $response = $this->post(route('api.server.rcon', $server->id), ['command' => 'test']);
        $response->assertStatus(Response::HTTP_OK);

        // getPlayers
        $response = $this->get(route('api.server.rcon.players', $server->id));
        $response->assertStatus(Response::HTTP_OK);

        // message
        $response = $this->post(route('api.server.rcon.players.message', $server->id), ['message' => 'test']);
        $response->assertStatus(Response::HTTP_OK);

        // kick
        $response = $this->post(route('api.server.rcon.players.kick', $server->id), [
            'player'    => 1,
            'reason'    => 'test',
        ]);
        $response->assertStatus(Response::HTTP_OK);

        // ban
        $response = $this->post(route('api.server.rcon.players.ban', $server->id), [
            'player'    => 1,
            'reason'    => 'test',
            'time'      => 0,
        ]);
        $response->assertStatus(Response::HTTP_OK);
    }
}