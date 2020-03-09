<?php

namespace Gameap\Http\Requests\API;

use Gameap\Http\Requests\Request;

class ServerTaskUpdateRequest extends Request
{
    public function rules()
    {
        return [
            'task'              => 'required|string|max:16',
            'repeat'            => 'required|numeric|digits_between:1,255',
            'repeat_period'     => 'required',
            'execute_date'      => 'required',
        ];
    }
}