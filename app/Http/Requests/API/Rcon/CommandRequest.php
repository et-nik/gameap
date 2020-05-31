<?php

namespace Gameap\Http\Requests\API\Rcon;

use Gameap\Http\Requests\Request;

class CommandRequest extends Request
{
    public function rules()
    {
        return [
            'command' => 'required|string|max:127'
        ];
    }
}