<?php

namespace Gameap\Http\Requests;

class ProfileChangePasswordRequest extends Request
{
    /**
     * Rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'sometimes|string|min:6|confirmed',
        ];
    }
}
