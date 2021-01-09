<?php

namespace Gameap\Http\Requests\API;

use Gameap\Http\Requests\Request;

class ServerConsoleCommandRequest extends Request
{
    public function rules()
    {
        return [
            'command' => 'required',
        ];
    }
}
