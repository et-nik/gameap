<?php
namespace Gameap\Http\Requests;

use Gameap\Models\User;

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
            'password'  => 'sometimes|string|min:6|confirmed',
        ];
    }
}