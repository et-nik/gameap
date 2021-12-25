<?php

namespace Gameap\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Gameap\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map(): void
    {
        $this->mapWebAPIRoutes();

        $this->mapWebRoutes();

        $this->mapGdaemonApiRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware(['web', 'preferLanguage'])
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapWebAPIRoutes(): void
    {
        Route::prefix('web-api')
            ->middleware('api')
            ->as('web-api.')
            ->namespace($this->namespace . '\\WebAPI')
            ->group(base_path('routes/web_api.php'));
    }

    protected function mapAPIRoutes(): void
    {
        Route::prefix('api')
            ->middleware('auth:sanctum')
            ->as('api.')
            ->namespace($this->namespace . '\\API')
            ->group(base_path('routes/api.php'));
    }

    /**
     * Define the "gdaemon_api" routes for the application
     *
     * @return void
     */
    protected function mapGdaemonApiRoutes(): void
    {
        Route::prefix('gdaemon_api')
            ->middleware('gdaemon_api')
            ->as('gdaemon_api.')
            ->namespace($this->namespace . '\\GdaemonAPI')
            ->group(base_path('routes/gdaemon_api.php'));
    }
}
