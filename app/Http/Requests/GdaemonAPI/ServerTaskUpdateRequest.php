<?php

namespace Gameap\Http\Requests\GdaemonAPI;

class ServerTaskUpdateRequest extends JsonRequest
{
    public function rules()
    {
        return [
            'task'              => 'required|string|max:16',
            'repeat'            => 'required|numeric|digits_between:1,255',
            'repeat_period'     => 'required|numeric',
            'execute_date'      => 'required',
        ];
    }
}