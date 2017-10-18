<?php

namespace Gameap\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfileController extends AuthController
{
    public function index()
    {
        return view('profile', [
            'user' => $user = Auth::user(),
        ]);
    }
}
