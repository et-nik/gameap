<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginPageTest extends DuskTestCase
{
    /**
     * @return void
     * @throws \Throwable
     */
    public function testRedirect()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertPathIs('/login')
                    ->assertSee('GameAP');
        });
    }

    /**
     * @throws \Throwable
     */
    public function testLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('login', 'admin')
                ->type('password', 'fpwPOuZD')
                ->press('Login')
                ->assertPathIs('/home');
        });
    }
}
