<?php

namespace Gameap\Http\Requests;

class ServerRequest extends Request
{
    public function rules()
    {
        return [
            'enabled' => '',
            'blocked' => '',
            'installed' => '',
            'name' => 'required|max:128',
            'game_id' => 'required',
            'ds_id' => 'required',
            'game_mod_id' => 'required|exists:game_mods,id',
            'server_ip' => 'required',
            'server_port' => 'required|numeric|digits_between:1,65535',
            'dir' => 'required'
        ];
    }
}