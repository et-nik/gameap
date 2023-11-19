<?php

namespace Gameap\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \Gameap\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \Gameap\Http\Middleware\TrustProxies::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \Gameap\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Gameap\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            \Gameap\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            'bindings',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'gdaemon_api' => [
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth'                     => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic'               => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'abilities'                => \Laravel\Sanctum\Http\Middleware\CheckAbilities::class,
        'ability'                  => \Laravel\Sanctum\Http\Middleware\CheckForAnyAbility::class,
        'bindings'                 => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can'                      => \Illuminate\Auth\Middleware\Authorize::class,
        'guest'                    => \Gameap\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle'                 => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'isAdmin'                  => \Gameap\Http\Middleware\AdminMiddleware::class,
        'preferLanguage'           => \Gameap\Http\Middleware\PreferLanguageMiddleware::class,
        'gdaemonApiAuth'           => \Gameap\Http\Middleware\GdaemonApiAuth::class,
        'gdaemonVerifyApiToken'    => \Gameap\Http\Middleware\VerifyGdaemonApiToken::class,
        'gdaemonVerifySetupToken'  => \Gameap\Http\Middleware\VerifyGdaemonSetupToken::class,
        'gdaemonVerifyCreateToken' => \Gameap\Http\Middleware\VerifyGdaemonCreateToken::class,
    ];
}
