<?php

namespace Gameap\Exceptions\GdaemonAPI;

use Gameap\Exceptions\GameapException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class InvalidApiKeyException extends GameapException implements HttpExceptionInterface
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
