<?php

namespace Gameap\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \Gameap\Models\Server::class => \Gameap\Policies\ServerPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('server-control', 'Gameap\Policies\ServerPolicy@control');
        Gate::define('server-start', 'Gameap\Policies\ServerPolicy@start');
        Gate::define('server-stop', 'Gameap\Policies\ServerPolicy@stop');
        Gate::define('server-restart', 'Gameap\Policies\ServerPolicy@restart');
        Gate::define('server-pause', 'Gameap\Policies\ServerPolicy@pause');
        Gate::define('server-update', 'Gameap\Policies\ServerPolicy@update');
        Gate::define('server-files', 'Gameap\Policies\ServerPolicy@files');
        Gate::define('server-tasks', 'Gameap\Policies\ServerPolicy@tasks');
        Gate::define('server-settings', 'Gameap\Policies\ServerPolicy@settings');

        // Console
        Gate::define('server-console-view', 'Gameap\Policies\ServerPolicy@consoleView');
        Gate::define('server-console-send', 'Gameap\Policies\ServerPolicy@consoleSend');

        // RCON
        Gate::define('server-rcon', 'Gameap\Policies\ServerPolicy@rcon');
        Gate::define('server-rcon-console', 'Gameap\Policies\ServerPolicy@rconConsole');
        Gate::define('server-rcon-players', 'Gameap\Policies\ServerPolicy@rconPlayers');
    }
}
