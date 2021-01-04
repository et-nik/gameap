<?php

namespace Gameap\Repositories;

use Gameap\Exceptions\GameapException;
use Gameap\Http\Requests\ClientCertificatesRequest;
use Gameap\Models\ClientCertificate;
use Gameap\Services\CertificateService;
use Illuminate\Support\Facades\Storage;

class ClientCertificateRepository extends Repository
{
    public const STORAGE_CERTS_PATH = 'certs/client';

    /**
     * ClientCertificateRepository constructor.
     * @param ClientCertificate $clientCertificate
     */
    public function __construct(ClientCertificate $clientCertificate)
    {
        $this->model = $clientCertificate;
    }

    /**
     * @param int $perPage
     *
     * @return mixed
     */
    public function getAll($perPage = 20)
    {
        return ClientCertificate::orderBy('id')->paginate($perPage);
    }

    /**
     * @param ClientCertificatesRequest $request
     *
     * @return ClientCertificate
     * @throws GameapException
     */
    public function store(ClientCertificatesRequest $request)
    {
        $attributes = $request->all();
        
        if ($request->hasFile('certificate')) {
            $attributes['certificate'] = $request->file('certificate')->store(
                self::STORAGE_CERTS_PATH, 'local'
            );
        }

        if ($request->hasFile('private_key')) {
            $attributes['private_key'] = $request->file('private_key')->store(
                self::STORAGE_CERTS_PATH, 'local'
            );
        }
        
        if (!openssl_x509_check_private_key(Storage::get($attributes['certificate']), Storage::get($attributes['private_key']))) {
            throw new GameapException(__('client_certificates.private_key_not_correspond'));
        }

        $info = CertificateService::certificateInfo($attributes['certificate']);

        $attributes['expires'] = $info['expires'];
        $attributes['fingerprint'] = CertificateService::fingerprintString($attributes['certificate'], 'sha1');
        $attributes['private_key_pass'] = '';
        
        return ClientCertificate::create($attributes);
    }

    /**
     * @param ClientCertificate $clientCertificate
     * @param ClientCertificatesRequest $request
     */
    public function update(ClientCertificate $clientCertificate, array $request): void
    {
        $attributes = $request->all();

        if ($request->hasFile('certificate')) {
            $attributes['gdaemon_server_cert'] = $request->file('certificate')->store(
                self::STORAGE_CERTS_PATH, 'local'
            );
        }

        if ($request->hasFile('gdaemon_server_cert')) {
            $attributes['gdaemon_server_cert'] = $request->file('private_key')->store(
                self::STORAGE_CERTS_PATH, 'local'
            );
        }
        
        $clientCertificate->update($attributes);
    }

    /**
     * @param ClientCertificate $clientCertificate
     * @throws \Exception
     */
    public function destroy(ClientCertificate $clientCertificate): void
    {
        if (Storage::disk('local')->exists($clientCertificate->certificate)) {
            // TODO: Not working =(
            // Storage::disk('local')->delete('certs/client/' . $clientCertificate->certificate);

            $file = Storage::disk('local')
                ->getDriver()
                ->getAdapter()
                ->applyPathPrefix($clientCertificate->certificate);

            unlink($file);
        }

        if (Storage::disk('local')->exists($clientCertificate->private_key)) {
            $file = Storage::disk('local')
                ->getDriver()
                ->getAdapter()
                ->applyPathPrefix($clientCertificate->private_key);

            unlink($file);
        }

        $clientCertificate->delete();
    }

    /**
     * @param ClientCertificate $clientCertificate
     */
    public function certificateInfo(ClientCertificate $clientCertificate)
    {
        return CertificateService::certificateInfo($clientCertificate->certificate);
    }

    /**
     * @param int $id
     * @return ClientCertificate
     */
    public function getFirstOrGenerate()
    {
        $clientCertificate = ClientCertificate::select()->first();

        if (empty($clientCertificate)) {
            $attributes = $this->generate();
            $clientCertificate = ClientCertificate::create($attributes);
        } else {
            // Fix. If client certificate exists in database but not exists certificates files.
            // Delete invalid files. Generate new certificates.
            if (! Storage::exists($clientCertificate->certificate) || ! Storage::exists($clientCertificate->private_key)) {
                if (Storage::exists($clientCertificate->certificate)) {
                    Storage::delete($clientCertificate->certificate);
                }

                if (Storage::exists($clientCertificate->private_key)) {
                    Storage::delete($clientCertificate->private_key);
                }

                $attributes = $this->generate();

                $clientCertificate->fingerprint = $attributes['fingerprint'];
                $clientCertificate->expires = $attributes['expires'];
                $clientCertificate->certificate = $attributes['certificate'];
                $clientCertificate->private_key = $attributes['private_key'];
                $clientCertificate->private_key_pass = $attributes['private_key_pass'];
                $clientCertificate->save();
            }
        }

        return $clientCertificate;
    }

    /**
     * Generate certificate
     * Return array with paths to certificates
     *
     * @return array
     */
    private function generate()
    {
        $timestamp = time();
        $certificateName = self::STORAGE_CERTS_PATH . "/client_{$timestamp}.crt";
        $privateKeyName = self::STORAGE_CERTS_PATH . "/client_{$timestamp}.key";

        CertificateService::generate($certificateName, $privateKeyName);
        $info = CertificateService::certificateInfo($certificateName);

        return [
            'fingerprint' => CertificateService::fingerprintString($certificateName),
            'expires'     => $info['expires'],
            'certificate' => $certificateName,
            'private_key' => $privateKeyName,
            'private_key_pass' => '',
        ];
    }
}