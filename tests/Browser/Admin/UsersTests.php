<?php

namespace Tests\Browser\Admin;

use Facebook\WebDriver\WebDriverKeys;
use Gameap\Models\User;
use Laravel\Dusk\Browser;
use Tests\Browser\BrowserTestCase;
use Tests\Context\Browser\Models\ServerContextTrait;

class UsersTests extends BrowserTestCase
{
    use ServerContextTrait;

    public function testCreate()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/admin/users/create')
                ->type('login', 'br_test_user')
                ->type('email', 'br.test.user@example.com')
                ->type('password', '12345678')
                ->type('password_confirmation', '12345678')
                ->type('name', 'Browser Test User')
                ->select('roles[]', 'user')
                ->scrollIntoView('input[type=submit]')
                ->press(__('main.create'))
                ->assertPathIs('/admin/users')
                ->assertSee(__('users.create_success_msg'));
        });

        $this->assertDatabaseHas('users', [
            'login'             => 'br_test_user',
        ]);
    }

    public function testLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('login', 'br_test_user')
                ->type('password', '12345678')
                ->press('Login')
                ->assertPathIs('/home');

            $browser->visit('/admin/dedicated_servers')
                ->assertSee('Access Denied');

            $browser->visit('/admin/client_certificates')
                ->assertSee('Access Denied');

            $browser->visit('/admin/games')
                ->assertSee('Access Denied');

            $browser->visit('/admin/games/test/edit')
                ->assertSee('Access Denied');

            $browser->visit('/admin/gdaemon_tasks')
                ->assertSee('Access Denied');

            $browser->visit('/admin/servers')
                ->assertSee('Access Denied');

            $browser->visit('/admin/users')
                ->assertSee('Access Denied');

            $browser->visit('/modules')
                ->assertSee('Access Denied');

            $browser->visit('/update')
                ->assertSee('Access Denied');
        });
    }

    public function testEdit()
    {
        $this->browse(function (Browser $first, Browser $second) {
            $first->loginAs(User::find(1))
                ->visit('/admin/users')
                ->click('table > tbody > tr:nth-child(2) > td.text-nowrap > a.btn.btn-edit')
                ->assertPathIs('/admin/users/*/edit')
                ->type('password', '87654321')
                ->type('password_confirmation', '87654321')
                ->type('name', 'Browser Test User Edited')
                ->scrollIntoView('input[type=submit]')
                ->press(__('main.save'))
                ->assertPathIs('/admin/users')
                ->assertSee(__('users.update_success_msg'));

            $this->assertDatabaseHas('users', [
                'login'             => 'br_test_user',
                'name'              => 'Browser Test User Edited'
            ]);

            $second->visit('/login')
                ->type('login', 'br_test_user')
                ->type('password', '87654321')
                ->press('Login')
                ->assertPathIs('/home');
        });
    }

    public function testPasswordChanging()
    {
        $this->browse(function (Browser $admin, Browser $user) {
            // Change password to 11111122
            $admin->loginAs(User::find(1))
                ->visit('/admin/users')
                ->click('table.table-grid-models > tbody > tr:last-child > td.text-nowrap > a.btn.btn-edit')
                ->type('password', '11111122')
                ->type('password_confirmation', '11111122')
                ->scrollIntoView('input[type=submit]')
                ->press(__('main.save'))
                ->assertPathIs('/admin/users')
                ->assertSee(__('users.update_success_msg'));

            // Login with password 11111122
            $user->visit('/login')
                ->assertPathIs('/login')
                ->type('login', 'br_test_user')
                ->type('password', '11111122')
                ->press('Login')
                ->assertPathIs('/home')
                ->logout();

            // Change password to 12345678
            $admin->visit('/admin/users')
                ->click('table.table-grid-models > tbody > tr:last-child > td.text-nowrap > a.btn.btn-edit')
                ->type('password', '12345678')
                ->type('password_confirmation', '12345678')
                ->scrollIntoView('input[type=submit]')
                ->press(__('main.save'))
                ->assertPathIs('/admin/users')
                ->assertSee(__('users.update_success_msg'));

            // Try to login with 11111122 password
            $user->visit('/login')
                ->assertPathIs('/login')
                ->type('login', 'br_test_user')
                ->type('password', '11111122')
                ->press('Login')
                ->assertPathIs('/login')
                ->assertSee('These credentials do not match our records.');

            // Login with 12345678 password
            $user->visit('/login')
                ->assertPathIs('/login')
                ->type('login', 'br_test_user')
                ->type('password', '12345678')
                ->press('Login')
                ->assertPathIs('/home')
                ->logout();

            // Update user without password changing
            $admin->visit('/admin/users')
                ->click('table.table-grid-models > tbody > tr:last-child > td.text-nowrap > a.btn.btn-edit')
                ->scrollIntoView('input[type=submit]')
                ->press(__('main.save'))
                ->assertPathIs('/admin/users')
                ->assertSee(__('users.update_success_msg'));

            // Login with 12345678 password
            $user->visit('/login')
                ->assertPathIs('/login')
                ->type('login', 'br_test_user')
                ->type('password', '12345678')
                ->press('Login')
                ->assertPathIs('/home')
                ->logout();
        });
    }

    public function testServerPermission()
    {
        $this->givenGameServer();

        $this->browse(function (Browser $admin, Browser $user) {
            $admin->loginAs(User::find(1));
            $user->loginAs(User::find(2));

            $user->visit('/servers')
                ->assertDontSeeIn('table > tbody > tr > td:nth-child(1)', 'Test');

            $admin->loginAs(User::find(1))
                ->visit('/admin/users')
                ->click('table > tbody > tr:nth-child(2) > td.text-nowrap > a.btn.btn-edit')
                ->assertPathIs('/admin/users/*/edit');

            $admin->mouseover('input[type=search]');
            $admin->clickAndHold();
            $admin->releaseMouse();
            $admin->driver->getKeyboard()->sendKeys(['t', 'e', 's', 't']);
            sleep(5);
            $admin->driver->getKeyboard()->sendKeys(WebDriverKeys::ENTER);

            $admin->press(__('main.add'));

            $admin->waitFor('table:nth-child(1) > tbody > tr > td', 5);
            $admin->waitUntilMissing('ul.dropdown-menu', 5);

            $admin->scrollIntoView('input[type=submit]')
                ->press(__('main.save'));

            $user->visit('/servers')
                ->assertSeeIn('table > tbody > tr > td:nth-child(1)', 'Test')
                ->assertDontSeeIn('table > tbody > tr > td:nth-child(4)', 'Control');

            // Add and check each privileges

            // game-server-common
            $admin->visit('/admin/users')
                ->click('table > tbody > tr:nth-child(2) > td.text-nowrap > a.btn.btn-edit')
                ->assertPathIs('/admin/users/*/edit')
                ->click('table:nth-child(1) > tbody > tr > td:nth-child(3) > a')
                ->assertPathIs('/admin/users/*/servers/*/edit');

            $admin->click('label[for=game-server-common]')
                ->scrollIntoView('input[type=submit]')
                ->press(__('main.save'))
                ->assertPathIs('/admin/users/*/edit');

            $user->visit('/servers')
                ->assertSeeIn('table.table-grid-models > tbody > tr > td:nth-child(1)', 'Test')
                ->assertSeeIn('table.table-grid-models > tbody > tr > td:nth-child(4)', 'Control');

            $user->click('.server-control:nth-child(1) > a');
            $user->assertPathIs('/servers/*')
                ->assertSee('Commands')
                ->assertSee('Proccess status')
                ->assertDontSeeIn('#serverControl', 'Start')
                ->assertDontSeeIn('#serverControl', 'Stop')
                ->assertDontSeeIn('#serverControl', 'Restart')
                ->assertDontSeeIn('#serverControl', 'Update')
                ->assertDontSee('Files')
                ->assertDontSee('Settings');

            // game-server-start game-server-stop
            $admin->visit('/admin/users')
                ->click('table > tbody > tr:nth-child(2) > td.text-nowrap > a.btn.btn-edit')
                ->assertPathIs('/admin/users/*/edit')
                ->click('table:nth-child(1) > tbody > tr > td:nth-child(3) > a')
                ->assertPathIs('/admin/users/*/servers/*/edit');

            $admin->click('label[for=game-server-start]')
                ->click('label[for=game-server-stop]')
                ->scrollIntoView('input[type=submit]')
                ->press(__('main.save'))
                ->assertPathIs('/admin/users/*/edit');

            $user->visit('/servers');

            $serverOnline = $user->text('table.table-grid-models > tbody > tr > td:nth-child(3) > span') == 'online';

            if ($serverOnline) {
                $user->assertSeeIn('table.table-grid-models > tbody > tr > td:nth-child(4)', 'Stop');
            } else {
                $user->assertSeeIn('table.table-grid-models > tbody > tr > td:nth-child(4)', 'Start');
            }

            $user->assertDontSeeIn('table.table-grid-models > tbody > tr > td:nth-child(4)', 'Restart');

            $user->click('.server-control:nth-child(1) > a:last-child')
                ->assertPathIs('/servers/*');

            if ($serverOnline) {
                $user->assertSeeIn('#serverControl', 'Stop');
            } else {
                $user->assertSeeIn('#serverControl', 'Start');
            }

            $user->assertDontSeeIn('#serverControl', 'Restart')
                ->assertDontSeeIn('#serverControl', 'Update')
                ->assertDontSee('Files')
                ->assertDontSee('Settings');

            // game-server-restart

            $admin->visit('/admin/users')
                ->click('table > tbody > tr:nth-child(2) > td.text-nowrap > a.btn.btn-edit')
                ->assertPathIs('/admin/users/*/edit')
                ->click('table:nth-child(1) > tbody > tr > td:nth-child(3) > a')
                ->assertPathIs('/admin/users/*/servers/*/edit');

            $admin->click('label[for=game-server-restart]')
                ->scrollIntoView('input[type=submit]')
                ->press(__('main.save'))
                ->assertPathIs('/admin/users/*/edit');

            $user->visit('/servers');
            $user->assertSeeIn('table.table-grid-models > tbody > tr > td:nth-child(4)', 'Restart');

            $user->click('.server-control:nth-child(1) > a:last-child')
                ->assertPathIs('/servers/*')
                ->assertSeeIn('#serverControl', 'Restart')
                ->assertDontSeeIn('#serverControl', 'Update')
                ->assertDontSee('Files')
                ->assertDontSee('Settings');

            // game-server-update

            $admin->visit('/admin/users')
                ->click('table > tbody > tr:nth-child(2) > td.text-nowrap > a.btn.btn-edit')
                ->assertPathIs('/admin/users/*/edit')
                ->click('table:nth-child(1) > tbody > tr > td:nth-child(3) > a')
                ->assertPathIs('/admin/users/*/servers/*/edit');

            $admin->click('label[for=game-server-update]')
                ->scrollIntoView('input[type=submit]')
                ->press(__('main.save'))
                ->assertPathIs('/admin/users/*/edit');

            $user->visit('/servers');

            $user->click('.server-control:nth-child(1) > a:last-child')
                ->assertPathIs('/servers/*')
                ->assertSeeIn('#serverControl', 'Update')
                ->assertDontSee('Files')
                ->assertDontSee('Settings');

            // game-server-files

            $admin->visit('/admin/users')
                ->click('table > tbody > tr:nth-child(2) > td.text-nowrap > a.btn.btn-edit')
                ->assertPathIs('/admin/users/*/edit')
                ->click('table:nth-child(1) > tbody > tr > td:nth-child(3) > a')
                ->assertPathIs('/admin/users/*/servers/*/edit');

            $admin->click('label[for=game-server-files]')
                ->scrollIntoView('input[type=submit]')
                ->press(__('main.save'))
                ->assertPathIs('/admin/users/*/edit');

            $user->visit('/servers')
                ->click('.server-control:nth-child(1) > a:last-child')
                ->assertPathIs('/servers/*')
                ->assertSee('Files')
                ->assertDontSee('Settings');

            // game-server-settings

            $admin->visit('/admin/users')
                ->click('table > tbody > tr:nth-child(2) > td.text-nowrap > a.btn.btn-edit')
                ->assertPathIs('/admin/users/*/edit')
                ->click('table:nth-child(1) > tbody > tr > td:nth-child(3) > a')
                ->assertPathIs('/admin/users/*/servers/*/edit');

            $admin->click('label[for=game-server-settings]')
                ->scrollIntoView('input[type=submit]')
                ->press(__('main.save'))
                ->assertPathIs('/admin/users/*/edit');

            $user->visit('/servers')
                ->click('.server-control:nth-child(1) > a:last-child')
                ->assertPathIs('/servers/*')
                ->assertSee('Settings');

            // Disable game-server-common
            $admin->visit('/admin/users')
                ->click('table > tbody > tr:nth-child(2) > td.text-nowrap > a.btn.btn-edit')
                ->assertPathIs('/admin/users/*/edit')
                ->click('table:nth-child(1) > tbody > tr > td:nth-child(3) > a')
                ->assertPathIs('/admin/users/*/servers/*/edit');

            $admin->click('label[for=game-server-common]')
                ->scrollIntoView('input[type=submit]')
                ->press(__('main.save'))
                ->assertPathIs('/admin/users/*/edit');

            $user->refresh()
                ->assertPathIs('/servers/*')
                ->assertSee('This action is unauthorized.');

            $user->visit('/servers')
                ->assertSeeIn('table.table-grid-models > tbody > tr > td:nth-child(1)', 'Test')
                ->assertDontSeeIn('table.table-grid-models > tbody > tr > td:nth-child(4)', 'Control')
                ->assertDontSeeIn('table.table-grid-models > tbody > tr > td:nth-child(4)', 'Start')
                ->assertDontSeeIn('table.table-grid-models > tbody > tr > td:nth-child(4)', 'Stop')
                ->assertDontSeeIn('table.table-grid-models > tbody > tr > td:nth-child(4)', 'Restart')
                ->assertDontSeeIn('table.table-grid-models > tbody > tr > td:nth-child(4)', 'Update');
        });
    }
}
