<?php

namespace Gameap\Http\Requests;

use Gameap\Models\User;

class UserRequest extends Request
{
    /**
     * Rules
     * 
     * @return array
     */
    public function rules()
    {
        return ($this->method() === self::METHOD_PATCH)
            ? User::getUpdateRulesForId($this->route()->parameter('user')->id)
            : User::getCreateRules();
    }
}