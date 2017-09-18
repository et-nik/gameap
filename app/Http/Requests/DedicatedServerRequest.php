<?php

namespace Gameap\Http\Requests;

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
            'gdaemon_login' => 'required|max:128',
            'gdaemon_password' => 'required|max:128',
            'gdaemon_privkey' => 'required|max:128',
            'gdaemon_keypass' => 'required|max:128',
        ];
    }
}