<?php

namespace Tests\Browser\Admin;

use Gameap\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class GamesTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testCreateGame()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/home')
                ->clickLink('Games')
                ->assertPathIs('/admin/games')
                ->clickLink('Add Game')
                ->assertPathIs('/admin/games/create')
                ->type('code', 'test')
                ->type('start_code', 'test')
                ->type('name', 'Test')
                ->type('engine', 'Test')
                ->type('engine_version', '1.0')
                ->type('remote_repository', 'http://files.gameap.ru/test/test.tar.xz')
                ->scrollIntoView('input[type=submit]')
                ->press(__('main.create'))
                ->assertPathIs('/admin/games')
                ->assertSee(__('games.create_success_msg'));
        });

        $this->assertDatabaseHas('games', [
            'code'              => 'test',
            'name'              => 'Test',
            'engine'            => 'Test',
            'engine_version'    => '1.0',
        ]);
    }

    public function testEditGame()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/games/test/edit')
                ->type('engine_version', '1.0.0')
                ->scrollIntoView('input[type=submit]')
                ->press(__('main.save'))
                ->assertPathIs('/admin/games')
                ->assertSee(__('games.update_success_msg'));
        });

        $this->assertDatabaseHas('games', [
            'code'              => 'test',
            'name'              => 'Test',
            'engine'            => 'Test',
            'engine_version'    => '1.0.0',
        ]);
    }

    public function testCreateMod()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/home')
                ->clickLink('Games')
                ->assertPathIs('/admin/games')
                ->clickLink('Add Mod')
                ->assertPathIs('/admin/game_mods/create')
                ->select('game_code', 'test')
                ->type('name', 'Default')
                ->press('Create')
                ->assertPathIs('/admin/games')
                ->assertSee(__('games.mod_create_success_msg'));
        });
    }
}
