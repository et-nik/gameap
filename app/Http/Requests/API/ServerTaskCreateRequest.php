<?php

namespace Gameap\Http\Requests\API;

use Gameap\Http\Requests\Request;

class ServerTaskCreateRequest extends Request
{
    public function rules()
    {
        return [
            'server_id'         => 'required|numeric|exists:servers,id',
            'task'              => 'required|string|max:16',
            'repeat'            => 'required|numeric|digits_between:1,255',
            'repeat_period'     => 'required',
            'execute_date'      => 'required',
        ];
    }
}