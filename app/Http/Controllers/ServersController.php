<?php

namespace Gameap\Http\Controllers;

use Gameap\Http\Requests\ServerVarsRequest;
use Gameap\Models\Server;
use Gameap\Models\ServerSetting;
use Gameap\Repositories\ServerRepository;
use Illuminate\Support\Facades\Auth;

class ServersController extends AuthController
{
    /**
     * The ServerRepository instance.
     *
     * @var \Gameap\Repositories\ServerRepository
     */
    protected $repository;

    /**
     * Create a new ServersController instance.
     *
     * @param ServerRepository $repository
     */
    public function __construct(ServerRepository $repository)
    {
        parent::__construct();

        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('servers.list',[
            'servers' => $this->repository->getServersForAuth()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Gameap\Models\Server  $server
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View

     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Server $server)
    {
        $this->authorize('server-control', $server);

        return ($server->installed === $server::INSTALLED && $server->enabled && !$server->blocked) ?
            view('servers.view', compact('server'))
            : view('servers.not_active', compact('server'));
    }

    /**
     * @param Server $server
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function filemanager(Server $server)
    {
        $this->authorize('server-control', $server);
        $this->authorize('server-files', $server);

        return view('servers.filemanager', compact('server'));
    }

    /**
     * @param Server $server
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function settings(Server $server)
    {
        $this->authorize('server-settings', $server);

        $autostartSetting = $server->settings->where('name', 'autostart')->first()
            ?? new ServerSetting([
                'server_id' => $server->id,
                'name'      => 'autostart',
                'value'     => true,
            ]);

        $autostart = $autostartSetting->value;

        return view('servers.settings', compact('server', 'autostart'));
    }

    /**
     * @param ServerVarsRequest $request
     * @param Server $server
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function updateSettings(ServerVarsRequest $request, Server $server)
    {
        $this->authorize('server-control', $server);
        $this->authorize('server-settings', $server);

        $this->repository->updateAutostart($server, ($request->get('autostart') == true));
        $this->repository->updateVars($server, $request);

        return redirect()->route('servers.settings', ['server' => $server->id])
            ->with('success', __('servers.update_success_msg'));
    }
}