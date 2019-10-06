<?php

namespace Gameap\Repositories;

use Gameap\Models\DedicatedServer;
use Gameap\Models\ClientCertificate;
use Gameap\Http\Requests\DedicatedServerRequest;
use Gameap\Repositories\ClientCertificateRepository;
use Gameap\Services\CertificateService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DedicatedServersRepository extends Repository
{
    /**
     * @var \Gameap\Repositories\ClientCertificateRepository
     */
    protected $clientCertificateRepository;

    /**
     * DedicatedServersRepository constructor.
     * @param DedicatedServer $dedicatedServer
     * @param \Gameap\Repositories\ClientCertificateRepository $clientCertificateRepository
     */
    public function __construct(
        DedicatedServer $dedicatedServer,
        ClientCertificateRepository $clientCertificateRepository
    ) {
        $this->model = $dedicatedServer;
        $this->clientCertificateRepository = $clientCertificateRepository;
    }

    /**
     * @param int $perPage
     * @return mixed
     */
    public function getAll($perPage = 20)
    {
        return DedicatedServer::orderBy('id')->withCount('servers')->paginate($perPage);
    }

    /**
     * @param int $id
     * @return array
     */
    public function getIpList(int $id)
    {
        return $this->model->select('ip')
            ->where('id', '=', $id)
            ->first()
            ->ip;
    }

    /**
     * @param array $attributes
     * @return DedicatedServer
     */
    public function store(array $attributes)
    {
        $attributes['ip'] = array_filter($attributes['ip'], function($value) {
            return !empty($value);
        });

        if (empty($attributes['client_certificate_id'])) {
            $clientCertificate = $this->clientCertificateRepository->getFirstOrGenerate();
            $attributes['client_certificate_id'] = $clientCertificate->id;
        }

        $attributes['gdaemon_api_key'] = Str::random(64);

        $attributes['enabled'] = $attributes['enabled'] ?? 1;
        $attributes['os'] = $attributes['os'] ?? 'linux';

        return DedicatedServer::create($attributes);
    }

    /**
     * @param DedicatedServer $dedicatedServer
     * @throws \Exception
     */
    public function destroy(DedicatedServer $dedicatedServer)
    {
        if ($dedicatedServer->gdaemon_server_cert != CertificateService::ROOT_CA_CERT &&
            Storage::disk('local')->exists($dedicatedServer->gdaemon_server_cert)
        ) {
            // TODO: Not working =(
            // Storage::disk('local')->delete($dedicatedServer->gdaemon_server_cert);

            $certificateFile = Storage::disk('local')
                ->getDriver()
                ->getAdapter()
                ->applyPathPrefix($dedicatedServer->gdaemon_server_cert);

            if (file_exists($certificateFile)) {
                unlink($certificateFile);
            }
        }

        $dedicatedServer->delete();
    }

    /**
     * @param array $fields
     * @param DedicatedServer        $dedicatedServer
     */
    public function update(DedicatedServer $dedicatedServer, array $attributes)
    {
        $attributes['ip'] = array_filter($attributes['ip'], function($value) {
            return !empty($value);
        });

        $dedicatedServer->update($attributes);
    }
}