<?php

namespace Tests\Browser\Admin;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Gameap\Models\User;
use Tests\DuskTestCase;

class DedicatedServerTest extends DuskTestCase
{
    /**
     * @throws \Throwable
     */
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
            $this->assertRegExp('/^curl http:\/\/.*$/', $value);

            exec($value, $output, $exitCode);
            $this->assertSame(0, $exitCode);
        });
    }
}
