<?php

namespace Tests\Browser\Admin;

use Gameap\Models\DedicatedServer;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Gameap\Models\User;
use Tests\Browser\BrowserTestCase;
use Tests\DuskTestCase;

class DedicatedServerTest extends BrowserTestCase
{
    public function testEditDedicatedServer()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/home')
                ->clickLink('Dedicated servers')
                ->assertPathIs('/admin/dedicated_servers')
                // Click edit button (second)
                ->click('table.table-grid-models > tbody > tr:first-child > td.text-nowrap > a:nth-child(2)')
                ->assertPathIs('/admin/dedicated_servers/*/edit');

            $browser->type('name', 'Browser Test Server')
                ->type('provider', 'Test');

            $internalIp = $this->selectInternalIp();

            if ($internalIp != null) {
                // Click GDaemon tab
                $browser->click('ul.nav-tabs > li:last-child > a.nav-link')
                    ->type('gdaemon_host', $internalIp);
            }

            $browser->scrollIntoView('input[type=submit]')
                ->press('Save')
                ->assertPathIs('/admin/dedicated_servers')
                ->assertSee('Dedicated server updated successfully');
        });
    }

    private function selectInternalIp()
    {
        foreach (DedicatedServer::select('ip')->first()->ip as $ip) {
            $ipParts = explode('.', $ip);

            if (in_array($ipParts[0], ['172', '10', '192', '127'])) {
                return $ip;
            }
        }

        return null;
    }
}
