<?php

namespace Tests\Browser\Admin;

use Gameap\Models\User;
use Laravel\Dusk\Browser;
use Tests\Browser\BrowserTestCase;
use Tests\Context\Browser\DaemonContextTrait;
use Tests\Context\Browser\Models\GameContextTrait;
use Tests\Context\Browser\Models\GameModContextTrait;
use Tests\Context\Browser\Models\ServerContextTrait;

class ServersTest extends BrowserTestCase
{
    use GameContextTrait;
    use GameModContextTrait;
    use ServerContextTrait;

    public function testEdit()
    {
        $this->givenGame();
        $this->givenGameMod();
        $gameServer = $this->givenGameServer();

        $this->browse(function (Browser $browser) use($gameServer) {
            $browser->loginAs(User::find(1))
                ->visit('/home')
                ->assertPathIs('/home')
                ->clickLink('Game servers')
                ->click('table > tbody > tr:nth-child(1) > td.text-nowrap > a')
                ->assertPathIs("/admin/servers/{$gameServer->id}/edit")
                ->type('name', 'Test Edited')
                ->type('start_command', './run.sh interactive')
                ->waitFor('#game_mod_id > option', 10)
                ->waitFor('#server_ip > option', 10)
                ->select('game_mod_id', 'test')
                ->scrollIntoView('input[type=submit]')
                ->press(__('main.save'))
                ->assertSee(__('servers.update_success_msg'));
        });

        $this->assertDatabaseHas('servers', [
            'name'              => 'Test Edited',
            'installed'         => 1,
        ]);
    }
}
