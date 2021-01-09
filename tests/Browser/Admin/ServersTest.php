<?php

namespace Tests\Browser\Admin;

use Facebook\WebDriver\WebDriverKeys;
use Gameap\Models\User;
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
                'game_id'           => 'test',
                'installed'         => 1,
            ]);
        });
    }

    public function testEdit()
    {
        $this->assertDatabaseHas('servers', [
            'name'              => 'Test',
            'game_id'           => 'test',
            'installed'         => 1,
        ]);

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
            'game_id'           => 'test',
            'installed'         => 1,
        ]);
    }

    public function testStart()
    {
        $this->assertDatabaseHas('servers', [
            'name'              => 'Test Edited',
            'game_id'           => 'test',
            'installed'         => 1,
        ]);

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

    public function testConsole()
    {
        $this->assertDatabaseHas('servers', [
            'name'              => 'Test Edited',
            'game_id'           => 'test',
            'installed'         => 1,
        ]);

        $this->browse(function (Browser $admin) {
            $admin->loginAs(User::find(1));

            $admin->visit('/servers');
            $serverOnline = $admin->text('table.table-grid-models > tbody > tr > td:nth-child(3) > span') == 'online';

            if (! $serverOnline) {
                $admin->click('.server-control:first-child > a')
                ->waitFor('div.modal-footer > button.btn.btn-success.bootbox-accept', 10)
                ->press(__('main.yes'))
                ->waitForText('Game Server started successfully', 60)
                ->press('OK')
                ->assertPathIs('/servers');
            }

            // go to server control
            $admin->click('.server-control:nth-child(1) > a:last-child')
                ->assertPathIs('/servers/*');

            $admin->waitFor('#terminalConsole', 5);
            sleep(3);
            $admin->assertSeeIn('#terminalConsole', 'Starting');

            $admin->scrollIntoView('input.terminal-input')
                ->mouseover('input.terminal-input')
                ->clickAndHold()
                ->releaseMouse();
            $admin->driver->getKeyboard()->sendKeys('Hello Console!');
            $admin->driver->getKeyboard()->sendKeys(WebDriverKeys::ENTER);
            sleep(4);

            $admin->scrollIntoView('#terminalConsole')
                ->assertSeeIn('#terminalConsole', 'Hello Console!');
        });
    }

      public function testStop()
      {
          $this->assertDatabaseHas('servers', [
              'name'              => 'Test Edited',
              'game_id'           => 'test',
              'installed'         => 1,
          ]);

          $this->browse(function (Browser $admin) {
              $admin->loginAs(User::find(1));

              $admin->visit('/servers');
              $serverOnline = $admin->text('table.table-grid-models > tbody > tr > td:nth-child(3) > span') == 'online';

              if (!$serverOnline) {
                  $admin->click('.server-control:first-child > a')
                      ->waitFor('div.modal-footer > button.btn.btn-success.bootbox-accept', 10)
                      ->press(__('main.yes'))
                      ->waitForText('Game Server started successfully', 60)
                      ->press('OK')
                      ->assertPathIs('/servers');
              }

              $admin->clickLink('Servers')
                ->click('.server-control:first-child > a')
                ->waitFor('div.modal-footer > button.btn.btn-success.bootbox-accept', 10)
                ->press(__('main.yes'))
                ->waitForText('Game Server stopped successfully', 60)
                ->press('OK')
                ->assertPathIs('/servers');

          });
      }

    public function testFilemanager()
    {
        $this->assertDatabaseHas('servers', [
            'name'              => 'Test Edited',
            'game_id'           => 'test',
            'installed'         => 1,
        ]);

        $this->browse(function (Browser $admin) {
            $admin->loginAs(User::find(1));

            $admin->visit('/servers')
                ->click('.server-control:nth-child(1) > a:last-child')
                ->assertPathIs('/servers/*');

            $admin->clickLink('Files')
                ->assertPathIs('/servers/*');

            $admin->waitFor('div.fm-content-body', 10);
            sleep(3);
            $admin->assertSeeIn(
                'div.fm-content-body > div.fm-table > table > tbody > tr:last-child > td:first-child',
                'run.sh'
            );

            // Create directory
            $admin->assertDontSeeIn(
                'div.fm-content-body > div.fm-table > table > tbody',
                'aaa-test-directory'
            );

            $admin->mouseover('button > i.fa-folder')
                ->clickAndHold()
                ->releaseMouse();

            $admin->waitFor('#fm-folder-name', 3)
                ->assertSee('Create new folder')
                ->type('#fm-folder-name', 'aaa-test-directory')
                ->press('Submit');

            sleep(1);

            $admin->assertSeeIn(
                'div.fm-content-body > div.fm-table > table > tbody',
                'aaa-test-directory'
            );
        });
    }
}
