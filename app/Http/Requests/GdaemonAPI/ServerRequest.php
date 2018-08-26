<?php

namespace Gameap\Http\Requests\GdaemonAPI;

use Illuminate\Http\Request;

class ServerRequest extends Request
{
    public function rules()
    {
        return [
            'installed' => 'numeric|digits_between:0,9',
            'process_active' => 'numeric|digits_between:0,2',
            'last_process_check' => 'numeric',
        ];
    }
}