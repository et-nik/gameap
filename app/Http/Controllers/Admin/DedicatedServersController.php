<?php

namespace Gameap\Http\Controllers\Admin;

use Gameap\Http\Controllers\AuthController;
use Gameap\Http\Requests\Request;
use Gameap\Models\ClientCertificate;
use Gameap\Models\DedicatedServer;
use Gameap\Repositories\DedicatedServersRepository;
use Gameap\Http\Requests\Admin\DedicatedServerRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Knik\Gameap\GdaemonStatus;
use RuntimeException;

class DedicatedServersController extends AuthController
{
    /**
     * The DedicatedServersRepository instance.
     *
     * @var \Gameap\Repositories\DedicatedServersRepository
     */
    protected $repository;

    /**
     * Create a new DedicatedServersController instance.
     *
     * @param  \Gameap\Repositories\DedicatedServersRepository $repository
     */
    public function __construct(DedicatedServersRepository $repository)
    {
        parent::__construct();

        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $dedicatedServers = $this->repository->getAll();

        return view('admin.dedicated_servers.list', [
            'dedicatedServers' => $dedicatedServers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Add auto setup token
        $autoSetupToken = env('DAEMON_SETUP_TOKEN');

        if (empty($autoSetupToken)) {
            $autoSetupToken = Str::random(24);
            Cache::put('gdaemonAutoSetupToken', $autoSetupToken, 300);
        }

        $clientCertificates = ClientCertificate::all(['id', 'fingerprint'])->pluck('fingerprint', 'id');
        return view('admin.dedicated_servers.create', compact('clientCertificates', 'autoSetupToken'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Gameap\Http\Requests\Admin\DedicatedServerRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(DedicatedServerRequest $request)
    {
        $attributes = $request->all();

        if ($request->hasFile('gdaemon_server_cert')) {
            $attributes['gdaemon_server_cert'] = $request->file('gdaemon_server_cert')->store(
                'certs/server', 'local'
            );
        }

        $this->repository->store($attributes);

        return redirect()->route('admin.dedicated_servers.index')
            ->with('success', __('dedicated_servers.create_success_msg'));
    }

    /**
     * Display the specified resource.
     *
     * @param \Gameap\Models\DedicatedServer $dedicatedServer
     * @param GdaemonStatus $gdaemonStatus
     * @return \Illuminate\View\View
     */
    public function show(DedicatedServer $dedicatedServer, GdaemonStatus $gdaemonStatus)
    {
        $gdaemonStatus->setConfig($dedicatedServer->gdaemonSettings());

        try {
            $gdaemonVersion = $gdaemonStatus->version();
            $baseInfo = $gdaemonStatus->infoBase();
        } catch (RuntimeException $e) {
            $gdaemonVersion = [];
            $baseInfo = [];
        }

        return view('admin.dedicated_servers.view',
            compact(
                'dedicatedServer',
                'gdaemonVersion',
                'baseInfo'
            )
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Gameap\Models\DedicatedServer  $dedicatedServer
     * @return \Illuminate\View\View
     */
    public function edit(DedicatedServer $dedicatedServer)
    {
        $clientCertificates = ClientCertificate::all(['id', 'fingerprint'])->pluck('fingerprint', 'id');
        return view('admin.dedicated_servers.edit', compact('dedicatedServer', 'clientCertificates'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Gameap\Http\Requests\Admin\DedicatedServerRequest  $request
     * @param  \Gameap\Models\DedicatedServer  $dedicatedServer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(DedicatedServerRequest $request, DedicatedServer $dedicatedServer)
    {
        $attributes = $request->all();
        
        if ($request->hasFile('gdaemon_server_cert')) {
            $attributes['gdaemon_server_cert'] = $request->file('gdaemon_server_cert')->store(
                'certs/server', 'local'
            );

            $certificateFile = Storage::disk('local')
                ->getDriver()
                ->getAdapter()
                ->applyPathPrefix($dedicatedServer->gdaemon_server_cert);
            
            if (file_exists($certificateFile)) {
                unlink($certificateFile);
            }
        }
        
        $this->repository->update($dedicatedServer, $attributes);

        return redirect()->route('admin.dedicated_servers.index')
            ->with('success',  __('dedicated_servers.update_success_msg'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Gameap\Models\DedicatedServer  $dedicatedServer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(DedicatedServer $dedicatedServer)
    {
        $this->repository->destroy($dedicatedServer);

        return redirect()->route('admin.dedicated_servers.index')
            ->with('success',  __('dedicated_servers.delete_success_msg'));
    }
}
