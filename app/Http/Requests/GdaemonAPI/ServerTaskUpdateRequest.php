<?php

namespace Gameap\Http\Requests\GdaemonAPI;

use Gameap\Http\Requests\JsonRequest;

class ServerTaskUpdateRequest extends JsonRequest
{
    public function rules()
    {
        return [
            'counter'       => 'nullable|integer',
            'repeat'        => 'nullable|integer|digits_between:1,255',
            'repeat_period' => 'nullable|integer',
            'execute_date'  => 'required',
        ];
    }
}
