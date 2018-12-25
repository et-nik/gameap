<?php

namespace Gameap\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpKernel\Exception\HttpException;

class VerifyGdaemonSetupToken
{
    public function handle($request, Closure $next)
    {
        $autoSetupToken = Cache::get('gdaemonAutoSetupToken');

        if ($request->route('token') != $autoSetupToken) {
            throw new HttpException(401, "Invalid token");
        }

        return $next($request);
    }
}