<?php

namespace Gameap\Http\Requests\Modules;

use Gameap\Http\Requests\Request;

class ModuleActionRequest extends Request
{
    public function rules()
    {
        return [
            'module'      => 'required|alpha_dash',
        ];
    }
}
