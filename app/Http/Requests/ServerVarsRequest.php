<?php

namespace Gameap\Http\Requests;

class ServerVarsRequest extends Request
{
    public function rules()
    {
        return [
            'vars'                => 'required|array',
            'autostart'           => 'nullable|boolean',
            'update_before_start' => 'nullable|boolean',
        ];
    }

    public function vars(): array
    {
        return $this->get('vars');
    }

    public function autostart(): bool
    {
        return $this->get('autostart') !== null && $this->get('autostart');
    }

    public function updateBeforeStart(): bool
    {
        return $this->get('update_before_start') !== null && $this->get('update_before_start');
    }
}
