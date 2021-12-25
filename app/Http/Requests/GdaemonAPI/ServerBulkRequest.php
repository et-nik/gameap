<?php

namespace Gameap\Http\Requests\GdaemonAPI;

use Illuminate\Support\Arr;

class ServerBulkRequest extends JsonRequest
{
    public function rules(): array
    {
        return [
            '*.id'                 => 'numeric',
            '*.installed'          => 'nullable|numeric|digits_between:0,9',
            '*.process_active'     => 'nullable|numeric|digits_between:0,1',
            '*.last_process_check' => '',
        ];
    }

    public function values(): array
    {
        return array_map(function ($v) {
            return Arr::only($v, ['id', 'installed', 'process_active', 'last_process_check']);
        }, $this->all());
    }
}
