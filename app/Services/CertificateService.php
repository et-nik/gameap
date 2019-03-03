<?php

namespace Gameap\Services;

use Illuminate\Support\Facades\Storage;

class CertificateService
{
    const ROOT_CA = 'root.crt';
    const ROOT_KEY = 'root.key';

    const CERT_DN = [
        "countryName" => "RU",
        "stateOrProvinceName" => "GameAP",
        "localityName" => "GameAP",
        "organizationName" => "GameAP.ru",
        "organizationalUnitName" => "Development",
        "commonName" => "GameAP",
        "emailAddress" => "support@gameap.ru"
    ];

    const CERT_DAYS = 3650;

    /**
     * Generate root certificate
     */
    static public function generateRoot()
    {
        $privateKey = openssl_pkey_new();
        $certificate = openssl_csr_new(self::CERT_DN, $privateKey);
        $certificate = openssl_csr_sign($certificate, null, $privateKey, 3650);

        openssl_x509_export($certificate, $pemCertificate);
        openssl_pkey_export($privateKey, $pemPrivateKey);

        Storage::put(self::ROOT_CA, $pemCertificate);
        Storage::put(self::ROOT_KEY, $pemPrivateKey);
    }

    /**
     * @param $certificatePath string   path to certificate in storage
     * @param $keyPath string   path to key in storage
     */
    static public function generate($certificatePath, $keyPath)
    {
        $privateKey = openssl_pkey_new();
        $certificate = openssl_csr_new(self::CERT_DN, $privateKey);

        if (!Storage::exists(self::ROOT_CA)) {
            self::generateRoot();
        }

        $rootCa = Storage::get(self::ROOT_CA);
        $rootKey = Storage::get(self::ROOT_KEY);
        $certificate = openssl_csr_sign($certificate, $rootCa, $rootKey, 3650);

        openssl_x509_export($certificate, $pemCertificate);
        openssl_pkey_export($privateKey, $pemPrivateKey);

        Storage::makeDirectory('client_certificates');

        Storage::put($certificatePath, $pemCertificate);
        Storage::put($keyPath, $pemPrivateKey);
    }

    /**
     * @param $certificatePath string path to certificate in storage
     */
    static public function signCertificate($certificatePath)
    {
        if (!Storage::exists(self::ROOT_CA)) {
            self::generateRoot();
        }

        $rootCa = Storage::get(self::ROOT_CA);
        $rootKey = Storage::get(self::ROOT_KEY);
        $certificate = Storage::get($certificatePath);

        $signedCertificate = openssl_csr_sign($certificate, $rootCa, $rootKey, 3650);
        openssl_x509_export($signedCertificate, $pemCertificate);
        $pathinfo = pathinfo($certificatePath);

        Storage::put($pathinfo['dirname'] . '/' . $pathinfo['filename'] . 'crt', $pemCertificate);
    }
}