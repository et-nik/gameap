<?php

namespace Gameap\Http\Requests\Admin;

use Gameap\Http\Requests\Request;

class GameRequest extends Request
{
    public function rules()
    {
        return [
            'code'                 => 'unique:games|alpha_num|max:16',
            'name'                 => 'required|min:2',
            'engine'               => 'required|min:2',
            'engine_version'       => 'required',
            'steam_app_id_linux'         => 'nullable|integer',
            'steam_app_id_windows'         => 'nullable|integer',
            'steam_app_set_config' => '',
            'local_repository_linux'     => '',
            'local_repository_windows'     => '',
            'remote_repository_linux'    => '',
            'remote_repository_windows'    => '',
        ];
    }
}
