<?php

namespace Tests\Browser\Admin;

use Gameap\Models\User;
use Laravel\Dusk\Browser;
use Tests\Context\Browser\Models\GameContextTrait;
use Tests\Context\Browser\Models\GameModContextTrait;
use Tests\Context\Browser\Models\ServerContextTrait;
use Tests\DuskTestCase;

class ServersTest extends DuskTestCase
{
    use ServerContextTrait;
    use GameContextTrait;
    use GameModContextTrait;

    public function testCreate()
    {
        //$this->givenGame();
        $this->givenGameMod();

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/home')
                ->clickLink('Game servers')
                ->assertPathIs('/admin/servers')
                ->clickLink('Create')
                ->assertPathIs('/admin/servers/create')
                ->assertDontSee('Leave blank to set automatically')
                ->clickLink(__('main.more'))
                ->waitFor('input[name=dir]', 2)
                ->assertVisible('input[name=dir]')
                ->type('name', 'Test')
                ->select('game_id', 'test')
                ->waitFor('#game_mod_id > option', 10)
                ->select('game_mod_id')
                ->type('dir', 'servers/test')
                ->select('ds_id')
                ->waitFor('#server_ip > option', 10)
                ->select('server_ip')
                ->scrollIntoView('input[type=submit]')
                ->press(__('main.create'))
                ->assertPathIs('/admin/servers')
                ->assertSee(__('servers.create_success_msg'));

            $browser->clickLink('GDaemon tasks')
                ->assertPathIs('/admin/gdaemon_tasks')
                ->click('table > tbody > tr:nth-child(1) > td.text-nowrap > a')
                ->assertPathIs('/admin/gdaemon_tasks/*');

            $browser->waitUsing(120, 2, function () use ($browser) {
                $status = $browser->text('table > tbody > tr:nth-child(2) > td > span');

                if ($status == 'waiting') {
                    $browser->refresh();
                }

                return $status == 'success';
            });

            $browser->assertSee('Exited with 0');

            $this->assertDatabaseHas('servers', [
                'name'              => 'Test',
                'game_id'           => 'test',
                'installed'         => 1,
            ]);
        });
    }

    public function testEdit()
    {
        $this->browse(function (Browser $browser) {
            $gameServer = $this->givenGameServer();
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
