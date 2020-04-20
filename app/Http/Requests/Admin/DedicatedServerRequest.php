<?php

namespace Gameap\Http\Requests\Admin;

use Gameap\Models\DedicatedServer;
use Gameap\Http\Requests\Request;

class DedicatedServerRequest extends Request
{
    public function rules()
    {
        return [
            'name' => 'required|max:128',
            'location' => 'required|max:128',
            'ip' => 'required',
            'work_path' => 'required|max:128',
            'gdaemon_host' => 'required|max:128',
            'gdaemon_port' => 'required|numeric|digits_between:1,65535',
            'gdaemon_login' => 'max:128',
            'gdaemon_password' => 'max:128',
            'gdaemon_api_key' => '',
            'gdaemon_server_cert' => 'sometimes',
            'client_certificate_id' => 'numeric|exists:client_certificates,id',
        ];
    }
}