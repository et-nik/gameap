<?php

namespace Gameap\Http\Requests;

class UserRequest extends Request
{
    public function rules()
    {
        return [
            'login' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'name' => 'string|max:255',
        ];
    }
}