<?php

namespace Gameap\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpKernel\Exception\HttpException;

class VerifyGdaemonCreateToken
{
    public function handle($request, Closure $next)
    {
        $autoCreateToken = Cache::get('gdaemonAutoCreateToken');

        if ($request->route('token') != $autoCreateToken) {
            throw new HttpException(401, 'Invalid token');
        }

        return $next($request);
    }
}