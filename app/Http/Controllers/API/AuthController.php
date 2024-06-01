<?php

namespace Gameap\Http\Controllers\API;

use Gameap\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    /**
     * @var Request
     */
    protected $request;

    /**
     * The maximum number of attempts to allow.
     * @var int
     */
    protected $maxAttempts = 5;

    /**
     * Number of minutes to throttle for.
     *
     * @var int
     */
    protected $decayMinutes = 3;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        $field = filter_var($this->request->get('login'), FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'login';

        $this->request->merge([$field => $this->request->get('login')]);

        return $field;
    }
}