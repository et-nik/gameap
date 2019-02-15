<?php

namespace Gameap\Http\Controllers\Admin;

use Gameap\Http\Controllers\AuthController;
use Gameap\Models\Server;
use Gameap\Repositories\ServerRepository;
use Gameap\Http\Requests\ServersSettingsRequest;

class ServersSettingsController extends AuthController
{
    /**
     * ServersSettingsController constructor.
     *
     * @param ServerRepository $serverRepository
     */
    public function __construct(ServerRepository $serverRepository)
    {
        parent::__construct();
        $this->serverRepository = $serverRepository;
    }

    /**
     * @param Server $server
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Server $server)
    {
        $settings = $server->settings;
        return view('admin.servers_settings.settings', compact('server', 'settings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ServersSettingsRequest $request
     * @param Server $server
     * @return \Illuminate\Http\RedirectResponse
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
            ->with('success', __('servers.settings_update_success_msg'));
    }
}