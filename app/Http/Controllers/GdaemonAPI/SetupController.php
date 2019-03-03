<?php

namespace Gameap\Http\Controllers\GdaemonAPI;

use Gameap\Repositories\DedicatedServersRepository;
use Gameap\Models\DedicatedServer;
use Gameap\Http\Requests\GdaemonAPI\DedicatedServerRequest;
use Gameap\Services\CertificateService;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SetupController extends BaseController
{
    /**
     * The DedicatedServersRepository instance.
     *
     * @var \Gameap\Repositories\DedicatedServersRepository
     */
    public $repository;

    /**
     * DedicatedServersController constructor.
     * @param DedicatedServersRepository $repository
     */
    public function __construct(DedicatedServersRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Return path to daemon script setup
     */
    public function setup(string $token)
    {
        if (app()->has('debugbar')) {
            app('debugbar')->disable();
        }

        Cache::forget('gdaemonAutoSetupToken');

        $gdaemonCreateToken = Str::random(24);
        Cache::put('gdaemonCreateToken', $gdaemonCreateToken, 30);

        return "export createToken={$gdaemonCreateToken};
            export panelHost=" . url('/') . ";
            curl -sL https://raw.githubusercontent.com/gameap/auto-install-scripts/master/debian/install-gdaemon-en.sh | bash --";
    }

    /**
     * Creating a new Dedicated server. Uploading certificate
     *
     * Gets dedicated server attributes and server certificate
     * Return signed client certificate and signed server certificate
     *
     * @param string $token
     * @param DedicatedServerRequest $request
     * @return string
     */
    public function create(string $token, DedicatedServerRequest $request)
    {
        if (app()->has('debugbar')) {
            app('debugbar')->disable();
        }

        $gdaemonCreateToken = Cache::get('gdaemonCreateToken');
        Cache::forget('gdaemonCreateToken');

        $attributes = $request->all();

        if ($request->hasFile('gdaemon_server_cert')) {
            $csrPath = $request->file('gdaemon_server_cert')->getPathname();

            $serverSignedCertificatePath = CertificateService::signCertificate($csrPath);
            $attributes['gdaemon_server_cert'] = $serverSignedCertificatePath;
        } else {
            return "Error Empty GDdaemon server certificate";
        }

        $dedicatedServer = $this->repository->store($attributes);

        $certificate = Storage::disk('local')->get($dedicatedServer->clientCertificate->certificate);
        $serverSignedCertificate = Storage::disk('local')->get($serverSignedCertificatePath);

        return "Success {$dedicatedServer->id} {$dedicatedServer->gdaemon_api_key}\n{$certificate}\n\n{$serverSignedCertificate}";
    }
}