<?php

namespace Gameap\Providers;

use Gameap\Models\PersonalAccessToken;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;
use Silber\Bouncer\Bouncer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @param UrlGenerator $url
     * @return void
     */
    public function boot(UrlGenerator $url): void
    {
        Paginator::useBootstrap();
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

        if (strtolower(substr(config('app.url'), 0, 5)) == 'https') {
            $url->forceScheme('https');
        }

        $bouncer = $this->app->get(Bouncer::class);
        $bouncer->cache();

        Schema::defaultStringLength(128);

        Validator::extend('recaptcha', 'Gameap\\Validators\\ReCaptcha@validate');

        if (!Collection::hasMacro('paginate')) {
            Collection::macro(
                'paginate',
                function ($perPage = 15, $page = null, $options = []) {
                    $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
                    return (new LengthAwarePaginator(
                        $this->forPage($page, $perPage),
                        $this->count(),
                        $perPage,
                        $page,
                        $options
                    ))
                        ->withPath('');
                }
            );
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }
}
