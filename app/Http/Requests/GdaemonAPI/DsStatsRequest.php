<?php

namespace Gameap\Http\Requests\GdaemonAPI;

use Gameap\Http\Requests\JsonRequest;

class DsStatsRequest extends JsonRequest
{
    public function rules()
    {
        return [
            '*.time'     => 'date',
            '*.loa'      => 'required',
            '*.ram'      => 'required',
            '*.cpu'      => 'required',
            '*.ifstat'   => 'present',
            '*.ping'     => '',
            '*.drvspace' => 'required',
        ];
    }
}
