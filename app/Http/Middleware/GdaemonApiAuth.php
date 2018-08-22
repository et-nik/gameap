<?php

namespace Gameap\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class GdaemonApiAuth
{

    private $repository;

    public function __construct(\Gameap\Repositories\DedicatedServersRepository $dedicatedServersRepository)
    {
        $this->repository = $dedicatedServersRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();

        if (is_null($token)) {
            throw new HttpException(401, null, null, ['WWW-Authenticate' => 'Bearer']);
        }

        return $next($request);
    }
}