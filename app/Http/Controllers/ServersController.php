<?php

namespace Gameap\Http\Controllers;

use Gameap\Http\Requests\ServerVarsRequest;
use Gameap\Models\Server;
use Gameap\Models\ServerSetting;
use Gameap\Repositories\ServerRepository;
use Gameap\Services\RconService;
use Illuminate\Support\Facades\Auth;
use Knik\GRcon\Exceptions\GRconException;

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
     * @param RconService $rconService
     * @param \Gameap\Models\Server $server
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(RconService $rconService, Server $server)
    {
        $this->authorize('server-control', $server);

        $autostartSetting = $server->settings->where('name', 'autostart')->first()
            ?? new ServerSetting([
                'server_id' => $server->id,
                'name'      => 'autostart',
                'value'     => false,
            ]);

        $autostart = $autostartSetting->value;

        // TODO: Remove try catch
        try {
            $rconSupported = true;
            $rconSupportedFeatures = $rconService->supportedFeatures($server);
        } catch (GRconException $exception) {
            $rconSupported = false;
        }

        return ($server->installed === $server::INSTALLED && $server->enabled && !$server->blocked) ?
            view('servers.view', compact('server', 'autostart', 'rconSupportedFeatures', 'rconSupported'))
            : view('servers.not_active', compact('server'));
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

        return redirect()->to(route('servers.control', ['server' => $server->id]) . '#settings')
            ->with('success', __('servers.update_success_msg'));
    }
}