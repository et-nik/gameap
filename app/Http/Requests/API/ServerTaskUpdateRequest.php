<?php

namespace Gameap\Http\Requests\API;

use Gameap\Http\Requests\Request;
use Illuminate\Validation\Rule;

class ServerTaskUpdateRequest extends Request
{
    public function rules()
    {
        return [
            'command' => [
                'required',
                Rule::in(['start', 'stop', 'restart', 'update', 'reinstall']),
            ],
            'repeat'        => 'required|numeric|digits_between:1,255',
            'repeat_period' => 'sometimes|required_unless:repeat,1|nullable|regex:/^\d+\s\w+$/si',
            'execute_date'  => 'required',
        ];
    }
}
