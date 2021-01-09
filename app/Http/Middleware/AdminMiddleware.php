<?php

namespace Gameap\Http\Middleware;

use Bouncer;
use Closure;

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
