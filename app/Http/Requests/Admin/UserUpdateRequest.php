<?php

namespace Gameap\Http\Requests\Admin;

use Gameap\Http\Requests\Request;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends Request
{
    public function rules()
    {
        return [
            'login'     => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('users')->ignore($this->route('user'))
            ],
            'email'     => 'sometimes|string|email|max:255|unique:users',
            'password'  => 'nullable|string|min:6|confirmed',
            'name'      => 'string|nullable|max:255',
        ];
    }
}