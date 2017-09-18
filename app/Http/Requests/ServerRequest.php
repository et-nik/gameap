<?php

namespace Gameap\Http\Requests;

class ServerRequest extends Request
{
    public function rules()
    {
        return [
            'name' => 'required|max:128',
            'code_name' => 'required',
            'game_id' => 'required',
            'ds_id' => 'required',
            'game_mod_id' => '',
            'server_ip' => 'required',
            'server_port' => 'required',
            'dir' => 'required',
        ];
    }
}