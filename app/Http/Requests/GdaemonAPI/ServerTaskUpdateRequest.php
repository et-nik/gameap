<?php

namespace Gameap\Http\Requests\GdaemonAPI;

class ServerTaskUpdateRequest extends JsonRequest
{
    public function rules()
    {
        return [
            'repeat'            => 'nullable|integer|digits_between:1,255',
            'repeat_period'     => 'nullable|integer',
            'execute_date'      => 'required',
        ];
    }
}