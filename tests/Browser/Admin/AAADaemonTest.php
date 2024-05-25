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

    /**
     * @group daemon
     */
    public function testCreateDedicatedServer()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/')
                ->clickLink('Dedicated servers')
                ->assertPathIs('/admin/nodes')
                ->clickLink('Create')
                ->scrollIntoView('input[type=submit]')
                ->assertPathIs('/admin/node/create')
                ->waitForText('Dedicated Server Auto Setup', 10);

            $value = $browser->text('code.curl-link');
            $this->assertMatchesRegularExpression('/^curl http:\/\/.*$/', $value);

            exec($value, $output, $exitCode);
            $this->assertSame(0, $exitCode);
        });
    }
}
