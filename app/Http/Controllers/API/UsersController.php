<?php

namespace Gameap\Http\Controllers\API;

use Gameap\Models\User;
use Illuminate\Http\Request;
use Gameap\Http\Controllers\AuthController;

class UsersController extends AuthController
{
    public function index()
    {
        $users = User::all();

        return response()->json($users);
    }

    public function store(Request $request)
    {
        $user = User::create($request->all());

        return response()->json($user, 201);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());

        return response()->json($user, 200);
    }

    public function destroy($id)
    {
        User::destroy($id);

        return response()->json(null, 204);
    }
}
