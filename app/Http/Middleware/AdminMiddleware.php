<?php

namespace Gameap\Http\Middleware;

use Illuminate\Http\Request;
use Silber\Bouncer\Bouncer;
use Closure;

class AdminMiddleware
{
    /** @var Bouncer */
    private $bouncer;

    public function __construct(Bouncer $bouncer)
    {
        $this->bouncer = $bouncer;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$this->bouncer->can('admin roles & permissions')) {
            abort('403', 'Access Denied');
        }

        return $next($request);
    }
}
