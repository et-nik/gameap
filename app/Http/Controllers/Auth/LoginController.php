<?php

namespace Gameap\Http\Controllers\Auth;

use \Illuminate\Http\Request;
use Gameap\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

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
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        $field = filter_var($this->request->input('login'), FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'login';

        $this->request->merge([$field => $this->request->input('login')]);

        return $field;
    }
}
