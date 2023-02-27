<?php

namespace Tests\Browser\Admin;

use Gameap\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\BrowserTestCase;
use Tests\Context\Browser\Models\GameContextTrait;
use Tests\Context\Browser\Models\GameModContextTrait;
use Tests\Context\Browser\Models\ServerContextTrait;
use Tests\Context\Browser\Models\UserContextTrait;
use Tests\DuskTestCase;

class GamesTest extends BrowserTestCase
{
    use GameContextTrait;
    use GameModContextTrait;

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
                ->type('name', 'Test')
                ->type('engine', 'Test')
                ->type('engine_version', '2.0')
                ->type('remote_repository_linux', 'http://files.gameap.ru/test/test.tar.xz')
                ->scrollIntoView('input[type=submit]')
                ->press(__('main.create'))
                ->assertPathIs('/admin/games')
                ->assertSee(__('games.create_success_msg'));
        });

        $this->assertDatabaseHas('games', [
            'code'              => 'test',
            'name'              => 'Test',
            'engine'            => 'Test',
            'engine_version'    => '2.0',
            'remote_repository_linux' => 'http://files.gameap.ru/test/test.tar.xz',
        ]);
    }

    public function testEditGame()
    {
        $this->givenGame();

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/games/test/edit')
                ->type('name', 'Test Edited')
                ->type('engine', 'Test Edited')
                ->type('engine_version', '1.0.0')
                ->scrollIntoView('input[type=submit]')
                ->press(__('main.save'))
                ->assertPathIs('/admin/games')
                ->assertSee(__('games.update_success_msg'));
        });

        $this->assertDatabaseHas('games', [
            'code'              => 'test',
            'name'              => 'Test Edited',
            'engine'            => 'Test Edited',
            'engine_version'    => '1.0.0',
        ]);
    }

    public function testCreateMod()
    {
        $this->givenGame();

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/home')
                ->clickLink('Games')
                ->assertPathIs('/admin/games')
                ->clickLink('Add Mod')
                ->assertPathIs('/admin/game_mods/create')
                ->select('game_code', 'test')
                ->type('name', 'Default')
                ->scrollIntoView('input[type=submit]')
                ->press(__('main.create'))
                ->assertPathIs('/admin/games')
                ->assertSee(__('games.mod_create_success_msg'));
        });

        $this->assertDatabaseHas('game_mods', [
            'game_code'              => 'test',
            'name'                   => 'Default',
        ]);
    }
}
