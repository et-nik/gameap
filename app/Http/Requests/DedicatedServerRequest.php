<?php

namespace Gameap\Http\Requests;

use Gameap\Models\DedicatedServer;

class DedicatedServerRequest extends Request
{
    public function rules()
    {
        return ($this->method() === self::METHOD_PATCH)
            ? DedicatedServer::getUpdateRulesForId($this->route()->parameter('dedicatedServer')->id)
            : DedicatedServer::getCreateRules();
    }
}