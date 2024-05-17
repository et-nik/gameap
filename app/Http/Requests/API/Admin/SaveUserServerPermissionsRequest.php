<?php

namespace Gameap\Http\Requests\API\Admin;

use Gameap\Http\Requests\JsonRequest;

class SaveUserServerPermissionsRequest extends JsonRequest
{
    public function rules()
    {
        return [
            '*.permission' => 'string|required',
            '*.value' => 'boolean|required',
        ];
    }
}