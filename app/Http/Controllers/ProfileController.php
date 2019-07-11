<?php

namespace Gameap\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Gameap\Http\Requests\ProfileChangePasswordRequest;
use Hash;

class ProfileController extends AuthController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('profile', [
            'user' => $user = Auth::user(),
        ]);
    }

    /**
     * @param ProfileChangePasswordRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(ProfileChangePasswordRequest $request)
    {
        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            return redirect()->back()->with("error", __('profile.password_not_match_msg'));
        }

        Auth::user()->update($request->only('password'));
        
        return redirect()->route('profile')
            ->with('success', __('profile.password_change_success_msg'));
    }
}
