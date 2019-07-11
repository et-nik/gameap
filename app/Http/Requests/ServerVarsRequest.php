<?php

namespace Gameap\Http\Requests;


class ServerVarsRequest extends Request
{
    public function rules()
    {
        return [
            'vars' => 'required|array',
        ];
    }
}