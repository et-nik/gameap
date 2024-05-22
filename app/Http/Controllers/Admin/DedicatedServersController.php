<?php

namespace Gameap\Http\Controllers\Admin;

use Gameap\Helpers\OsHelper;
use Gameap\Http\Controllers\AuthController;
use Gameap\Http\Requests\Admin\DedicatedServerRequest;
use Gameap\Models\ClientCertificate;
use Gameap\Models\DedicatedServer;
use Gameap\Repositories\NodeRepository;
use Gameap\Services\Daemon\CertificateService;
use Gameap\Services\Daemon\DebugService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Knik\Gameap\GdaemonStatus;
use RuntimeException;
use ZipArchive;

class DedicatedServersController extends AuthController
{
    /**
     * The DedicatedServersRepository instance.
     *
     * @var \Gameap\Repositories\NodeRepository
     */
    protected $repository;

    /** @var DebugService */
    protected $debugService;

    public function __construct(
        NodeRepository $repository,
        DebugService   $downloadDebugService
    ) {
        parent::__construct();

        $this->repository           = $repository;
        $this->debugService = $downloadDebugService;
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
            'dedicatedServers' => $dedicatedServers,
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
                'certs/server',
                'local'
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
    public function show()
    {
        return view('admin.dedicated_servers.view');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Gameap\Models\DedicatedServer  $dedicatedServer
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('admin.dedicated_servers.edit');
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
                'certs/server',
                'local'
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
            ->with('success', __('dedicated_servers.update_success_msg'));
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
            ->with('success', __('dedicated_servers.delete_success_msg'));
    }

    public function logsZip(DedicatedServer $dedicatedServer)
    {
        try {
            $zipPath = $this->debugService->downloadLogs($dedicatedServer);
        } catch (RuntimeException $exception) {
            return redirect()->route('admin.dedicated_servers.show', [$dedicatedServer->id])
                ->with('error', $exception->getMessage());
        }

        return response()->download($zipPath, "logs.zip");
    }

    public function certificatesZip(DedicatedServer $dedicatedServer)
    {
        $key                     = CertificateService::generateKey();
        $csr                     = CertificateService::generateCsr($key);
        $serverSignedCertificate = CertificateService::signCsr($csr);

        $zipFilePath = OsHelper::tempFile();
        $zip = new ZipArchive();
        $zip->open($zipFilePath, ZipArchive::CREATE);
        $zip->addFromString("server.key", $key);
        $zip->addFromString("server.crt", $serverSignedCertificate);
        $zip->addFromString("ca.crt", CertificateService::getRootCert());
        $zip->addFromString(
            "README.md",
            "* Move this files to certs directory (For linux: /etc/gameap-daemon/certs/)\n" .
            "* Edit gameap-daemon configuration, set `ca_certificate_file`, `certificate_chain_file` and `private_key_file`"
        );
        $zip->close();

        return response()->download($zipFilePath, "certificates.zip");
    }
}
