<?php

namespace Gameap\Http\Requests\GdaemonAPI;

class ServerTaskFailRequest extends JsonRequest
{
    public function rules()
    {
        return [
            'output'            => 'required|string',
        ];
    }
}