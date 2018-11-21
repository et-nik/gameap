<?php

namespace Gameap\Providers;

use Illuminate\Support\ServiceProvider;
use Storage;
use League\Flysystem\Filesystem;
use Knik\Flysystem\Gameap\GameapAdapter;

class GdaemonFilesServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
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
    public function register()
    {
        //
    }
}