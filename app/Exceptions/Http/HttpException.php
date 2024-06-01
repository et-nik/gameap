<?php

namespace Gameap\Exceptions\Http;

use Gameap\Exceptions\GameapException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class HttpException extends GameapException implements HttpExceptionInterface
{
    public $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;

    public $headers = [];

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getHeaders()
    {
        return $this->headers;
    }
}
