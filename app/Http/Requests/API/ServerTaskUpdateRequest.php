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
            'repeat_period'     => 'sometimes|required_unless:repeat,1|nullable|regex:/^\d+\s\w+$/si',
            'execute_date'      => 'required',
        ];
    }
}