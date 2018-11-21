<?php
namespace Gameap\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\HttpException;;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Gameap\Models\DedicatedServer;
use Gameap\Exceptions\GdaemonAPI\InvalidTokenExeption;

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
            throw new HttpException(Response::HTTP_UNAUTHORIZED, "Token not set", null, ['X-Auth-Token']);
        }

        try {
            $dedicatedServer = DedicatedServer::where('gdaemon_api_token', '=', $authToken)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            throw new InvalidTokenExeption("Invalid api token");
        }

        app()->instance(DedicatedServer::class, $dedicatedServer);

        return $next($request);
    }
}