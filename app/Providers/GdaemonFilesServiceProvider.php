<?php

namespace Gameap\Providers;

use Illuminate\Support\ServiceProvider;
use Knik\Flysystem\Gameap\GameapAdapter;
use League\Flysystem\Filesystem;
use Storage;

class GdaemonFilesServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        Storage::extend('gameap', function($app, $config) {
            return new Filesystem(new GameapAdapter($config));
        });
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }
}