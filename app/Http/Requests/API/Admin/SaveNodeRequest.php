<?php

namespace Gameap\Http\Requests\API\Admin;

use Gameap\Http\Requests\JsonRequest;

class SaveNodeRequest extends JsonRequest
{
    public function rules()
    {
        return [
            'id'                    => 'numeric',
            'name'                  => 'required|max:128',
            'location'              => 'required|max:128',
            'ip'                    => 'required',
            'work_path'             => 'required|max:128',
            'gdaemon_host'          => 'required|max:128',
            'gdaemon_port'          => 'required|numeric|digits_between:1,65535',
            'gdaemon_login'         => 'max:128',
            'gdaemon_password'      => 'max:128',
            'gdaemon_api_key'       => '',
            'gdaemon_server_cert'   => 'sometimes',
            'client_certificate_id' => 'numeric|exists:client_certificates,id',
            'script_install'        => '',
            'script_reinstall'      => '',
            'script_update'         => '',
            'script_start'          => '',
            'script_pause'          => '',
            'script_unpause'        => '',
            'script_stop'           => '',
            'script_kill'           => '',
            'script_restart'        => '',
            'script_status'         => '',
            'script_stats'          => '',
            'script_get_console'    => '',
            'script_send_command'   => '',
            'script_delete'         => '',
        ];
    }

    public function id(): int
    {
        return $this->get('id');
    }
}