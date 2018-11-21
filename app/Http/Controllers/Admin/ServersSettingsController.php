<?php

namespace Gameap\Http\Controllers\Admin;

use Gameap\Http\Controllers\AuthController;
use Gameap\Models\Server;
use Gameap\Repositories\ServerRepository;
use Gameap\Http\Requests\ServersSettingsRequest;

class ServersSettingsController extends AuthController
{
    /**
     * Create a new ServersController instance.
     *
     * @param  \Gameap\Repositories\ServerRepository $repository
     */
    public function __construct(ServerRepository $serverRepository)
    {
        parent::__construct();
        $this->serverRepository = $serverRepository;
    }

    /**
     * @param  \Gameap\Models\Server  $server
     */
    public function edit(Server $server)
    {
        $settings = $server->settings;
        return view('admin.servers_settings.settings', compact('server', 'settings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Gameap\Http\Requests\ServersSettingsRequest  $request
     * @param  \Gameap\Models\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function update(ServersSettingsRequest $request, Server $server)
    {
        $all = $request->all();

        foreach ($server->settings as $setting) {
            if (isset($all['value'][$setting->id])) {
                $setting->value = $all['value'][$setting->id];
                $setting->save();
            }
        }

        return redirect()->route('admin.servers.index')
            ->with('success','Game server settings updated successfully');
    }
}