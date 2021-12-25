<?php

namespace Gameap\Exceptions\GdaemonAPI;

use Gameap\Exceptions\GameapException;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class InvalidTokenExeption extends GameapException implements HttpExceptionInterface
{
    public function getStatusCode()
    {
        return Response::HTTP_UNAUTHORIZED;
    }

    public function getHeaders()
    {
        return [];
    }
}
