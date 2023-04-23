<?php

namespace Gameap\Http\Controllers;

use Gameap\Http\Requests\ServerVarsRequest;
use Gameap\Models\GdaemonTask;
use Gameap\Models\Server;
use Gameap\Repositories\GdaemonTaskRepository;
use Gameap\Repositories\ServerRepository;
use Gameap\Services\RconService;

class ServersController extends AuthController
{
    /** @var ServerRepository */
    protected $repository;

    /** @var GdaemonTaskRepository */
    protected $gdaemonTaskRepository;

    public function __construct(ServerRepository $repository, GdaemonTaskRepository $gdaemonTaskRepository)
    {
        parent::__construct();

        $this->repository = $repository;
        $this->gdaemonTaskRepository = $gdaemonTaskRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('servers.list', [
            'servers' => $this->repository->getServersForAuth(),
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

        $autostartSetting = $server->getSetting($server::AUTOSTART_SETTING_KEY)->value;
        $updateBeforeStartSetting = $server->getSetting($server::UPDATE_BEFORE_START_SETTING_KEY)->value;

        if ($server->isActive()) {
            $view = view('servers.view', [
                'server' => $server,
                'autostart' => $autostartSetting,
                'updateBeforeStart' => $updateBeforeStartSetting,
                'rconSupportedFeatures' => $rconService->supportedFeatures($server),
                'rconSupported' => $rconService->supportedFeatures($server)['rcon'],
            ]);
        } else {
            $installationTaskId = $this->gdaemonTaskRepository->getOneWorkingTaskId(
                $server->id,
                [GDaemonTask::TASK_SERVER_INSTALL, GDaemonTask::TASK_SERVER_UPDATE]
            );
            $view = view('servers.not_active', [
                'server' => $server,
                'installationTaskExists' => $installationTaskId !== 0,
            ]);
        }

        return $view;
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

        $this->repository->updateSettings($server, $request);
        $this->repository->updateVars($server, $request);

        return redirect()->to(route('servers.control', ['server' => $server->id]) . '#settings')
            ->with('success', __('servers.update_success_msg'));
    }
}
