<?php
namespace Gameap\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use \Illuminate\Database\Eloquent\ModelNotFoundException;
use Gameap\Models\DedicatedServer;

class VerifyGdaemonApiToken
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
        $authToken = $request->header('X-Auth-Token');

        if (is_null($authToken)) {
            throw new HttpException(401, "Token not set", null, ['X-Auth-Token']);
        }

        try {
            $dedicatedServer = DedicatedServer::where('gdaemon_api_token', '=', $authToken)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            throw new AccessDeniedHttpException;
        }

        app()->instance(DedicatedServer::class, $dedicatedServer);

        return $next($request);
    }
}