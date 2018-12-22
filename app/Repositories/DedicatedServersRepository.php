<?php

namespace Gameap\Repositories;

use Gameap\Models\DedicatedServer;
use Gameap\Models\ClientCertificate;
use Gameap\Http\Requests\DedicatedServerRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DedicatedServersRepository
{
    protected $model;

    public function __construct(DedicatedServer $dedicatedServer)
    {
        $this->model = $dedicatedServer;
    }

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
            $attributes['client_certificate_id'] = ClientCertificate::select('id')->firstOrFail()->id;
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
        if (! Storage::disk('local')->exists('gdaemon_certs/' . $dedicatedServer->gdaemon_server_cert)) {
            // TODO: Not working =(
            // Storage::disk('local')->delete('gdaemon_certs/' . $dedicatedServer->gdaemon_server_cert);

            $file = Storage::disk('local')
                ->getDriver()
                ->getAdapter()
                ->applyPathPrefix($dedicatedServer->gdaemon_server_cert);

            unlink($file);
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