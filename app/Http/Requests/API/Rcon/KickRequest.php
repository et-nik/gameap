<?php

namespace Gameap\Http\Requests\API\Rcon;

use Gameap\Http\Requests\Request;

class KickRequest extends Request
{
    public function rules()
    {
        return [
            'player' => 'required|max:127',
            'reason' => 'string|max:127',
        ];
    }
}