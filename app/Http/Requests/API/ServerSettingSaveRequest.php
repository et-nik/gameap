<?php

namespace Gameap\Http\Requests\API;

use Gameap\Http\Requests\Request;

class ServerSettingSaveRequest extends Request
{
    public function rules()
    {
        return [
            '*.name' => 'required|string',
            '*.value' => 'nullable',
        ];
    }
}