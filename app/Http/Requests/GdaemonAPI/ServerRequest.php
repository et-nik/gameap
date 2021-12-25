<?php

namespace Gameap\Http\Requests\GdaemonAPI;

class ServerRequest extends JsonRequest
{
    public function rules()
    {
        return [
            'installed'          => 'nullable|numeric|digits_between:0,9',
            'process_active'     => 'nullable|numeric|digits_between:0,1',
            'last_process_check' => '',
        ];
    }

    public function installed(): int
    {
        return $this->get('installed');
    }

    public function processActive(): int
    {
        return $this->get('process_active');
    }

    public function lastProcessCheck(): string
    {
        return $this->get('last_process_check');
    }
}
