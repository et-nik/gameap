<?php

namespace Gameap\Http\Middleware;

use Illuminate\Http\Request;
use Closure;

class PreferLanguageMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!extension_loaded('intl')) {
            return $next($request);
        }

        $headerValue = $request->server('HTTP_ACCEPT_LANGUAGE');
        if ($headerValue !== null && !is_array($headerValue) && $headerValue !== "") {
            $locale = \Locale::acceptFromHttp($headerValue);

            if ($locale !== false && $locale !== "") {
                $locale = substr($locale, 0, 2);
                app()->setLocale($locale);
            }
        }


        return $next($request);
    }
}
