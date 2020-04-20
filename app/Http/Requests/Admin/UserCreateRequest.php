<?php

namespace Gameap\Http\Requests\Admin;

use Gameap\Http\Requests\Request;

class UserCreateRequest extends Request
{
    public function rules()
    {
        return [
            'login'     => 'sometimes|string|max:255|unique:users',
            'email'     => 'sometimes|string|email|max:255|unique:users',
            'password'  => 'sometimes|string|min:6|confirmed',
            'name'      => 'string|nullable|max:255',
        ];
    }
}