<?php

namespace Gameap\Http\Requests;

class SendBugRequest extends Request
{
    public function rules()
    {
        return [
            'summary' => 'required|string|max:64',
            'description' => 'required|string',
        ];
    }
}