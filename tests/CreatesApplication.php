<?php

namespace Tests;

use Gameap\Models\Server;
use Gameap\Models\User;
use Gameap\Repositories\UserRepository;
use Illuminate\Contracts\Console\Kernel;
use Silber\Bouncer\Bouncer;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    public function loadFixtures(): void
    {
        $this->artisan('db:seed');
        $this->artisan('db:seed', ['--class' => 'DedicatedServersTableSeeder']);
    }
}
