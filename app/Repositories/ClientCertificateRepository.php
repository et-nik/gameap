<?php

namespace Gameap\Repositories;

use Gameap\Models\ClientCertificate;
use Illuminate\Support\Facades\Storage;

class ClientCertificateRepository
{
    /**
     * @var ClientCertificate
     */
    protected $model;

    /**
     * ClientCertificateRepository constructor.
     * @param ClientCertificate $clientCertificate
     */
    public function __construct(ClientCertificate $clientCertificate)
    {
        $this->model = $clientCertificate;
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
        $certificateData = array(
            "countryName" => "RU",
            "stateOrProvinceName" => "GameAP",
            "localityName" => "GameAP",
            "organizationName" => "GameAP.ru",
            "organizationalUnitName" => "Development",
            "commonName" => "GameAP",
            "emailAddress" => "support@gameap.ru"
        );

        $privateKey = openssl_pkey_new();
        $certificate = openssl_csr_new($certificateData, $privateKey);
        $certificate = openssl_csr_sign($certificate, null, $privateKey, 3650);

        openssl_x509_export($certificate, $pemCertificate);
        openssl_pkey_export($privateKey, $pemPrivateKey);

        Storage::makeDirectory('client_certificates');

        $timestamp = time();
        $certificateName = "client_certificates/client_{$timestamp}.crt";
        $privateKeyName = "client_certificates/client_{$timestamp}.key";

        Storage::put($certificateName, $pemCertificate);
        Storage::put($privateKeyName, $pemPrivateKey);

        return [
            'certificate' => $certificateName,
            'private_key' => $privateKeyName,
            'private_key_pass' => '',
        ];
    }
}