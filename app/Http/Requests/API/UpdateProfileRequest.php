<?php

namespace Gameap\Http\Requests\API;

use Gameap\Http\Requests\JsonRequest;

class UpdateProfileRequest extends JsonRequest
{
    public function rules()
    {
        return [
            'name' => 'sometimes|string|max:255',
            'current_password' => 'sometimes|string|min:8',
            'password' => 'sometimes|string|min:8',
        ];
    }
}