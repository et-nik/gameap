<?php

namespace Gameap\Http\Requests\GdaemonAPI;


class ServerBulkRequest extends JsonRequest
{
    public function rules()
    {
        return [
            '*.id' => 'numeric',
            '*.installed' => 'numeric|digits_between:0,9',
            '*.process_active' => 'numeric|digits_between:0,1',
            '*.last_process_check' => '',
        ];
    }
}