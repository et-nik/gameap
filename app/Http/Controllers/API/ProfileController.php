<?php

namespace Gameap\Http\Controllers\API;

use Gameap\Http\Controllers\AuthController;
use Gameap\Http\Requests\API\UpdateProfileRequest;
use Gameap\Models\User;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Illuminate\Contracts\Hashing\Hasher;

class ProfileController extends AuthController
{
    /** @var AuthFactory */
    protected $authFactory;

    protected $hasher;

    public function __construct(
        AuthFactory $auth,
        Hasher $hasher
    )
    {
        parent::__construct();

        $this->authFactory = $auth;
        $this->hasher = $hasher;
    }

    public function show()
    {
        /** @var User $user */
        $user = $this->authFactory->guard()->user();

        return response()->json([
            'id' => $user->id,
            'login' => $user->login,
            'name' => $user->name,
            'email' => $user->email,
            'roles' => $user->roles->pluck('name'),
        ]);
    }

    public function save(UpdateProfileRequest $request)
    {
        /** @var User $user */
        $user = $this->authFactory->guard()->user();

        if ($request->has('current_password')) {
            if (!($this->hasher->check($request->get('current_password'), $user->password))) {
                return response()->json(['error' => __('profile.password_not_match_msg')], 400);
            }

            $user->update($request->only('password'));
        }

        if ($request->get('name') !== $user->name) {
            $user->update($request->only('name'));
        }

        return response()->json(['message' => 'success']);
    }
}