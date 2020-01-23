<?php

namespace Gameap\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Bouncer;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Bouncer::can('admin roles & permissions')) {
            abort('403', 'Access Denied');
        }

        return $next($request);
    }
}
