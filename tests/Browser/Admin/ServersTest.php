<?php

namespace Tests\Browser\Admin;

use Gameap\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ServersTest extends DuskTestCase
{
    public function testCreate()
    {
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
                'game_id'           => 'test'
            ]);
        });
    }

    public function testEdit()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/home')
                ->clickLink('Game servers')
                ->click('table > tbody > tr:nth-child(1) > td.text-nowrap > a')
                ->assertPathIs('/admin/servers/*/edit')
                ->type('name', 'Test Edited')
                ->type('start_command', './run.sh interactive')
                ->waitFor('#game_mod_id > option', 10)
                ->waitFor('#server_ip > option', 10)
                ->scrollIntoView('input[type=submit]')
                ->press(__('main.save'))
                ->assertSee(__('servers.update_success_msg'));
        });

        $this->assertDatabaseHas('servers', [
            'name'              => 'Test Edited',
            'game_id'           => 'test'
        ]);
    }

    public function testStart()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/home')
                ->clickLink('Servers')
                ->click('.server-control:first-child > a')
                ->waitFor('div.modal-footer > button.btn.btn-success.bootbox-accept', 10)
                ->press(__('main.yes'))
                ->waitForText('Game Server started successfully', 60)
                ->press('OK')
                ->assertPathIs('/servers');

            $browser->waitUsing(60, 2, function () use ($browser) {
                return $browser->text('table > tbody > tr > td:nth-child(3) > span') == 'online';
            });

            $this->assertEquals('online', $browser->text('table > tbody > tr > td:nth-child(3) > span'));
        });
    }
}
