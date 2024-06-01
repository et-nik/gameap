<?php

namespace Gameap\Http\Controllers\API;

use Gameap\Helpers\OsHelper;
use Gameap\Http\Controllers\AuthController;
use Gameap\Http\Requests\API\Admin\StoreNodeRequest;
use Gameap\Http\Requests\API\Admin\UpdateNodeRequest;
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
    public $repository;

    /** @var DebugService */
    protected $debugService;

    /** @var GdaemonStatus */
    private $gdaemonStatus;

    public function __construct(
        NodeRepository $repository,
        DebugService   $downloadDebugService,
        GdaemonStatus $gdaemonStatus
    ) {
        parent::__construct();

        $this->repository   = $repository;
        $this->debugService = $downloadDebugService;
        $this->gdaemonStatus = $gdaemonStatus;
    }

    public function list()
    {
        $collection = $this->repository->getAll();

        return $collection->map(function ($item) {
            return $item->only([
                'id',
                'enabled',
                'name',
                'os',
                'location',
                'provider',
                'ip',
            ]);
        });
    }

    public function summary()
    {
        $nodes = $this->repository->getAll();

        $online = 0;
        $offline = 0;

        foreach ($nodes as $node) {
            $this->gdaemonStatus->setConfig($node->gdaemonSettings());

            try {
                $this->gdaemonStatus->connect();
                $online++;
            } catch (\RuntimeException $exception) {
                $offline++;
            }

            $this->gdaemonStatus->disconnect();
        }

        return [
            'total' => $nodes->count(),
            'online' => $online,
            'offline' => $offline,
        ];
    }

    public function get(int $id)
    {
        return $this->repository->findById($id)->only(
            'id',
            'enabled',
            'name',
            'os',
            'location',
            'provider',
            'ip',
            'ram',
            'cpu',
            'work_path',
            'steamcmd_path',
            'gdaemon_host',
            'gdaemon_port',
            'gdaemon_api_key',
            'gdaemon_login',
            'gdaemon_password',
            'gdaemon_server_cert',
            'client_certificate_id',
            'prefer_install_method',
            'script_install',
            'script_reinstall',
            'script_update',
            'script_start',
            'script_pause',
            'script_unpause',
            'script_stop',
            'script_kill',
            'script_restart',
            'script_status',
            'script_stats',
            'script_get_console',
            'script_send_command',
            'script_delete',
            'created_at',
            'updated_at',
            'deleted_at',
        );
    }

    public function daemon(int $id, GdaemonStatus $gdaemonStatus)
    {
        $node = $this->repository->findById($id);
        $gdaemonStatus->setConfig($node->gdaemonSettings());

        try {
            $gdaemonVersion = $gdaemonStatus->version();
            $baseInfo       = $gdaemonStatus->infoBase();
        } catch (RuntimeException $e) {
            $gdaemonVersion = [];
            $baseInfo       = [];
        }

        return [
            'id'        => $node->id,
            'name'      => $node->name,
            'api_key'   => $node->gdaemon_api_key,
            'version'   => $gdaemonVersion,
            'base_info' => $baseInfo,
        ];
    }

    public function update($id, UpdateNodeRequest $request)
    {
        $attributes = $request->all();

        $node = $this->repository->findById($id);

        if (!empty($attributes['gdaemon_server_cert'])) {
            $cert = $attributes['gdaemon_server_cert'];
            if (!$cert) {
                return response()->json(['message' => 'Invalid certificate'], 400);
            }

            $path = 'certs/server/'.Str::Random(32).'.crt';
            Storage::disk('local')->put($path, $cert);

            $attributes['gdaemon_server_cert'] = $path;
        } else {
            $attributes['gdaemon_server_cert'] = $node->gdaemon_server_cert;
        }

        $this->repository->update($node, $attributes);

        return ['message' => 'success'];
    }

    public function setup()
    {
        // Add auto setup token
        $autoSetupToken = env('DAEMON_SETUP_TOKEN');

        if (empty($autoSetupToken)) {
            $autoSetupToken = Str::random(24);
            Cache::put('gdaemonAutoSetupToken', $autoSetupToken, 300);
        }

        return [
            'link' => route('gdaemon.setup', ['token' => $autoSetupToken]),
            'token' => $autoSetupToken,
            'host' => request()->getSchemeAndHttpHost(),
        ];
    }

    public function store(StoreNodeRequest $request)
    {
        $attributes = $request->all();

        $node = $this->repository->store($attributes);

        return ['message' => 'success', 'result' => $node->id];
    }

    public function destroy(int $id)
    {
        $node = $this->repository->findById($id);
        if (count($node->servers) > 0) {
            return ['message' => 'error', 'error' => __('dedicated_servers.delete_has_servers_error_msg')];
        }

        $this->repository->destroy($node);

        return ['message' => 'success'];
    }

    /**
     * @param int $id
     * @return array
     */
    public function getIpList(int $id)
    {
        return $this->repository->getIpList($id);
    }

    /**
     * @param int $id
     * @return array
     */
    public function getBusyPorts(int $id)
    {
        return $this->repository->getBusyPorts($id);
    }

    public function logsZip(int $id)
    {
        $node = $this->repository->findById($id);

        try {
            $zipPath = $this->debugService->downloadLogs($node);
        } catch (RuntimeException $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }

        return response()->download($zipPath, "logs.zip");
    }

    public function certificatesZip()
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
