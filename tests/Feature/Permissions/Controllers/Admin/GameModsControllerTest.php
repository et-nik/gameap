<?php

namespace Tests\Feature\Permissions\Controllers\Admin;

use Bouncer;
use Gameap\Models\GameMod;
use Gameap\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class GameModsControllerTest extends TestCase
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

    public function testAllow()
    {
        Bouncer::sync($this->user)->roles(['admin']);

        $gameMod = factory(GameMod::class)->create();

        // Create
        $response = $this->get(route('admin.game_mods.create', ['game' => $gameMod->game]));
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.game_mods.create');

        // Edit
        $response = $this->get(route('admin.game_mods.edit', ['game_mod' => $gameMod->id]));
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.game_mods.edit');

        // Update
        $response = $this->patch(route('admin.game_mods.update', ['game_mod' => $gameMod->id]), [
            'name' => 'Security Test'
        ]);
        $response->assertStatus(Response::HTTP_FOUND);

        // Store
        $response = $this->post(route('admin.game_mods.store', ['game' => $gameMod->game]), [
            'game_code'                     => 'cstrike',
            'name'                          => 'Secure Test Mod',
            'fast_rcon'                     => '',
            'vars'                          => '',
            'remote_repository'             => '',
            'local_repository'              => '',
            'default_start_cmd_linux'       => '',
            'default_start_cmd_windows'     => '',
            'kick_cmd'                      => '',
            'ban_cmd'                       => '',
            'chname_cmd'                    => '',
            'srestart_cmd'                  => '',
            'chmap_cmd'                     => '',
            'sendmsg_cmd'                   => '',
            'passwd_cmd'                    => '',
        ]);
        $response->assertStatus(Response::HTTP_FOUND);

        // Destroy
        $response = $this->delete(route('admin.game_mods.destroy', ['game_mod' => $gameMod->id]));
        $response->assertStatus(Response::HTTP_FOUND);
    }

    public function testForbidden()
    {
        Bouncer::sync($this->user)->roles(['admin']);
        Bouncer::sync($this->user)->forbiddenAbilities(['admin roles & permissions']);

        $gameMod = factory(GameMod::class)->create();

        // Create
        $response = $this->get(route('admin.game_mods.create', ['game' => $gameMod->game]));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // Edit
        $response = $this->get(route('admin.game_mods.edit', ['game_mod' => $gameMod->id]));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $gameMod = factory(GameMod::class)->create();

        // Update
        $response = $this->patch(route('admin.game_mods.update', ['game_mod' => $gameMod->id]), [
            'name' => 'Security Test'
        ]);
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // Store
        $response = $this->post(route('admin.game_mods.store', ['game_mod' => $gameMod->id]), [
            'game_code'                     => 'cstrike',
            'name'                          => 'Secure Test Mod',
            'fast_rcon'                     => '',
            'vars'                          => '',
            'remote_repository'             => '',
            'local_repository'              => '',
            'default_start_cmd_linux'       => '',
            'default_start_cmd_windows'     => '',
            'kick_cmd'                      => '',
            'ban_cmd'                       => '',
            'chname_cmd'                    => '',
            'srestart_cmd'                  => '',
            'chmap_cmd'                     => '',
            'sendmsg_cmd'                   => '',
            'passwd_cmd'                    => '',
        ]);
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // Destroy
        $response = $this->delete(route('admin.game_mods.destroy', $gameMod->id));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testForbiddenUser()
    {
        Bouncer::sync($this->user)->roles(['user']);

        $gameMod = factory(GameMod::class)->create();

        // Create
        $response = $this->get(route('admin.game_mods.create', ['game' => $gameMod->game]));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // Edit
        $response = $this->get(route('admin.game_mods.edit', ['game_mod' => $gameMod->id]));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $gameMod = factory(GameMod::class)->create();

        // Update
        $response = $this->patch(route('admin.game_mods.update', ['game_mod' => $gameMod->id]), [
            'name' => 'Security Test'
        ]);
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // Store
        $response = $this->post(route('admin.game_mods.store', $gameMod->id), [
            'game_code'                     => 'cstrike',
            'name'                          => 'Secure Test Mod',
            'fast_rcon'                     => '',
            'vars'                          => '',
            'remote_repository'             => '',
            'local_repository'              => '',
            'default_start_cmd_linux'       => '',
            'default_start_cmd_windows'     => '',
            'kick_cmd'                      => '',
            'ban_cmd'                       => '',
            'chname_cmd'                    => '',
            'srestart_cmd'                  => '',
            'chmap_cmd'                     => '',
            'sendmsg_cmd'                   => '',
            'passwd_cmd'                    => '',
        ]);
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // Destroy
        $response = $this->delete(route('admin.game_mods.destroy', ['game_mod' => $gameMod->id]));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}