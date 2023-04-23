<?php

namespace Gameap\Http\Requests\GdaemonAPI;

use Gameap\Http\Requests\JsonRequest;

class ServerTaskFailRequest extends JsonRequest
{
    public function rules()
    {
        return [
            'output' => 'required|string',
        ];
    }
}
