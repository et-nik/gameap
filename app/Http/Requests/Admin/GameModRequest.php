<?php

namespace Gameap\Http\Requests\Admin;

use Gameap\Models\GameMod;
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
        return ($this->method() === self::METHOD_PATCH)
            ? GameMod::getUpdateRulesForId($this->route()->parameter('game_mod')->id)
            : GameMod::getCreateRules();
    }
}