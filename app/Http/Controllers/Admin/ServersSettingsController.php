<?php

namespace Gameap\Http\Controllers\Admin;

use Gameap\Http\Controllers\AuthController;
use Gameap\Http\Requests\ServersSettingsRequest;
use Gameap\Models\Server;
use Gameap\Repositories\ServerRepository;
use Gameap\Repositories\ServerSettingsRepository;

class ServersSettingsController extends AuthController
{
    /**
     * The ServersRepository instance.
     *
     * @var \Gameap\Repositories\ServerRepository
     */
    protected $serverRepository;

    /**
     * @var \Gameap\Repositories\ServerSettingsRepository
     */
    protected $serverSettingsRepository;
    
    /**
     * ServersSettingsController constructor.
     *
     * @param ServerRepository $serverRepository
     */
    public function __construct(ServerRepository $serverRepository, ServerSettingsRepository $serverSettingsRepository)
    {
        parent::__construct();

        $this->serverRepository = $serverRepository;
        $this->serverSettingsRepository = $serverSettingsRepository;
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
     * Update server setting
     *
     * @param ServersSettingsRequest $request
     * @param Server $server
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function update(ServersSettingsRequest $request, Server $server)
    {
        $all = $request->only('settings');

        if (!empty($all['settings'])) {
            $this->serverSettingsRepository->saveSettings($server, $all['settings']);
        } else {
            // TODO: Remove all settings?
        }

        return redirect()->route('admin.servers.edit', [$server->id])
            ->with('success', __('servers.settings_update_success_msg'));
    }
}