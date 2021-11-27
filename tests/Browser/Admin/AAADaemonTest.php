<?php

namespace Tests\Browser\Admin;

use Gameap\Models\User;
use Laravel\Dusk\Browser;
use Tests\Context\Browser\Models\GameContextTrait;
use Tests\Context\Browser\Models\GameModContextTrait;
use Tests\Context\Browser\Models\ServerContextTrait;
use Tests\DuskTestCase;

// TODO: Deprecated. This test executed first. Make this test independent so you can run it as you like
class AAADaemonTest extends DuskTestCase
{
    use GameContextTrait;
    use GameModContextTrait;
    use ServerContextTrait;

    public function testCreateDedicatedServer()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/home')
                ->clickLink('Dedicated servers')
                ->assertPathIs('/admin/dedicated_servers')
                ->clickLink('Create')
                ->scrollIntoView('input[type=submit]')
                ->assertPathIs('/admin/dedicated_servers/create')
                ->waitForText('Dedicated Server Auto Setup', 10);

            $value = $browser->text('code');
            $this->assertMatchesRegularExpression('/^curl http:\/\/.*$/', $value);

            exec($value, $output, $exitCode);
            $this->assertSame(0, $exitCode);
        });
    }

    public function testCreate()
    {
        $this->givenGame();
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

                if ($status === 'waiting') {
                    $browser->refresh();
                }

                return $status === 'success';
            });

            $browser->assertSee('Downloading successfully completed');
        });

        $this->assertDatabaseHas('servers', [
            'name'              => 'Test',
            'game_id'           => 'test',
            'installed'         => 1,
        ]);
    }
}
