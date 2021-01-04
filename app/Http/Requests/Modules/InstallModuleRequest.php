<?php

namespace Gameap\Http\Requests\Modules;

use Gameap\Http\Requests\Request;

class InstallModuleRequest extends Request
{
    public function rules()
    {
        return [
            'module'      => 'required|alpha_dash',
            'version'     => 'required|regex:/^[a-z0-9\_\-\.]+$/i',
        ];
    }
}
