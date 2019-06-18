<?php

namespace Gameap\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($request->expectsJson() || $request->isJson()) {
            return $this->renderJson($request, $exception);
        } else {
            if ($exception instanceof \Gameap\Exceptions\GdaemonAPI\InvalidSetupTokenExeption) {
                if (app()->has('debugbar')) {
                    app('debugbar')->disable();
                }

                // Return bash
                return response()->make('echo "' . $exception->getMessage() . '"', 401);
            }
        }
        
        return parent::render($request, $exception);
    }
    
    public function renderJson($request, Exception $exception)
    {
        if ($exception instanceof \Gameap\Exceptions\Repositories\RecordExistExceptions) {
            return response()->json([
                'message' => $exception->getMessage(),
                'http_code' => Response::HTTP_UNPROCESSABLE_ENTITY
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Gdaemon API
        if ($exception instanceof \Gameap\Exceptions\GdaemonAPI\InvalidApiKeyException
            || $exception instanceof \Gameap\Exceptions\GdaemonAPI\InvalidTokenExeption
        ) {
            return response()->json([
                'message' => $exception->getMessage(),
                'http_code' => Response::HTTP_UNAUTHORIZED
            ], Response::HTTP_UNAUTHORIZED);
        } else if ($exception instanceof \Illuminate\Validation\ValidationException) {
            return response()->json([
                'message' => $exception->getMessage() . ' ' . $exception->validator->errors()->first(),
                'http_code' => Response::HTTP_UNPROCESSABLE_ENTITY
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return parent::render($request, $exception);
    }
}
