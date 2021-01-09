<?php

namespace Gameap\Http\Requests\Admin;

use Gameap\Http\Requests\Request;

class GameModRequest extends Request
{
    /**
     * Rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => 'required|string|max:255',
            'game_code' => 'sometimes|string|max:255|exists:games,code',

            'default_start_cmd_linux'   => 'nullable|string|max:1000',
            'default_start_cmd_windows' => 'nullable|string|max:1000',

            'vars.*.var'       => 'max:16',
            'vars.*.default'   => 'max:64',
            'vars.*.info'      => 'max:128',
            'vars.*.admin_var' => 'max:128',

            'fast_rcon.*.info'    => 'max:32',
            'fast_rcon.*.command' => 'max:128',
        ];
    }
}
