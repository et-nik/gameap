<?php

namespace Gameap\Http\Middleware;

use Closure;
use Gameap\Exceptions\GdaemonAPI\InvalidSetupTokenExeption;
use Illuminate\Support\Facades\Cache;

class VerifyGdaemonSetupToken
{
    public function handle($request, Closure $next)
    {
        $autoSetupToken = env('DAEMON_SETUP_TOKEN');

        if (empty($autoSetupToken)) {
            $autoSetupToken = Cache::get('gdaemonAutoSetupToken');
        }

        if ($request->route('token') != $autoSetupToken) {
            throw new InvalidSetupTokenExeption('Invalid token');
        }

        return $next($request);
    }
}
