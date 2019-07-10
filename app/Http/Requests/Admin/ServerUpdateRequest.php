<?php

namespace Gameap\Http\Requests\Admin;

use Gameap\Http\Requests\Request;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Route;

class ServerUpdateRequest extends Request
{
    public function rules()
    {
        $portRules = ['nullable', 'numeric', 'digits_between:1,65535',
            Rule::unique('servers', 'server_port')
                ->ignore($this->route('server'))
                ->where(function ($query) {
                    return $query
                        ->where('ds_id', $this->ds_id)
                        ->where('server_ip', $this->server_ip);
            }),
            Rule::unique('servers', 'query_port')
                ->ignore($this->route('server'))
                ->where(function ($query) {
                    return $query
                        ->where('ds_id', $this->ds_id)
                        ->where('server_ip', $this->server_ip);
            }),
            Rule::unique('servers', 'rcon_port')
                ->ignore($this->route('server'))
                ->where(function ($query) {
                    return $query
                        ->where('ds_id', $this->ds_id)
                        ->where('server_ip', $this->server_ip);
            }),
        ];

        return [
            'enabled' => '',
            'blocked' => '',
            'installed' => '',
            'name' => 'required|max:128',
            'game_id' => 'required',
            'ds_id' => 'required',
            'game_mod_id' => 'required|exists:game_mods,id',
            'server_ip' => 'required',

            'server_port' => array_merge(['required'], $portRules),
            'query_port' => array_merge(['nullable'], $portRules),
            'rcon_port' => array_merge(['nullable'], $portRules),

            'dir' => ['required', 'string', Rule::unique('servers', 'dir')
                ->ignore($this->route('server'))
                ->where(function ($query) {
                return $query->where('ds_id', $this->ds_id);
            })]
        ];
    }
}