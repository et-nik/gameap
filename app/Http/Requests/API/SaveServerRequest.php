<?php

namespace Gameap\Http\Requests\API;

use Gameap\Http\Requests\JsonRequest;
use Illuminate\Validation\Rule;

class SaveServerRequest extends JsonRequest
{
    public function rules(): array
    {
        $portRules = ['nullable', 'numeric', 'digits_between:1,65535',
            Rule::unique('servers', 'server_port')
                ->ignore($this->route('server'))
                ->where(function ($query) {
                    $q = $query
                        ->where('ds_id', $this->ds_id)
                        ->where('server_ip', $this->server_ip)
                        ->whereNull('deleted_at');

                    if ($this->id) {
                        $q->where('id', '!=', $this->id);
                    }

                    return $q;
                }),
            Rule::unique('servers', 'query_port')
                ->ignore($this->route('server'))
                ->where(function ($query) {
                    $q = $query
                        ->where('ds_id', $this->ds_id)
                        ->where('server_ip', $this->server_ip)
                        ->whereNull('deleted_at');

                    if ($this->id) {
                        $q->where('id', '!=', $this->id);
                    }

                    return $q;
                }),
            Rule::unique('servers', 'rcon_port')
                ->ignore($this->route('server'))
                ->where(function ($query) {
                    $q = $query
                        ->where('ds_id', $this->ds_id)
                        ->where('server_ip', $this->server_ip)
                        ->whereNull('deleted_at');

                    if ($this->id) {
                        $q->where('id', '!=', $this->id);
                    }

                    return $q;
                }),
        ];

        return [
            'id'          => '',
            'enabled'     => '',
            'blocked'     => '',
            'installed'   => '',
            'name'        => 'required|max:128',
            'game_id'     => 'required',
            'ds_id'       => 'required',
            'game_mod_id' => 'required|exists:game_mods,id',
            'server_ip'   => 'required',

            'server_port' => array_merge(['required'], $portRules),
            'query_port'  => array_merge(['nullable'], $portRules),
            'rcon_port'   => array_merge(['nullable'], $portRules),

            'dir' => ['nullable', 'string', Rule::unique('servers', 'dir')
                ->ignore($this->route('server'))
                ->where(function ($query) {
                    return $query->where('ds_id', $this->ds_id)
                        ->whereNull('deleted_at');
                }), ],
        ];
    }
}
