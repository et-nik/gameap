<?php

namespace Gameap\Http\Requests\GdaemonAPI;

use Gameap\Models\DedicatedServer;
use Gameap\Http\Requests\Request;

class DedicatedServerRequest extends Request
{
    public function rules()
    {
        return ($this->method() === self::METHOD_PATCH)
            ? DedicatedServer::getUpdateRulesForId($this->route()->parameter('dedicated_server')->id)
            : DedicatedServer::getCreateRules();
    }

    /**
     * Authorization
     *
     * @return boolean
     */
    public function authorize()
    {
        return true;
    }
}