<?php

namespace Gameap\Exceptions\Repositories;

use Gameap\Exceptions\Http\HttpException;
use Illuminate\Http\Response;

class InvalidCertificateException extends HttpException
{
    public function getStatusCode()
    {
        return Response::HTTP_UNPROCESSABLE_ENTITY;
    }

    public function getHeaders()
    {
        return [];
    }
}