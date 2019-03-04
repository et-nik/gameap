<?php

namespace Gameap\Services;

use Gameap\Exceptions\GameapException;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CertificateService
{
    const ROOT_CA = 'certs/root.crt';
    const ROOT_KEY = 'certs/root.key';

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
        $csr = openssl_csr_new(self::CERT_DN, $privateKey);
        $certificate = openssl_csr_sign($csr, null, $privateKey, 3650);

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
        $csr = openssl_csr_new(self::CERT_DN, $privateKey);

        if (!Storage::exists(self::ROOT_CA)) {
            self::generateRoot();
        }

        $rootCa = Storage::get(self::ROOT_CA);
        $rootKey = Storage::get(self::ROOT_KEY);
        $certificate = openssl_csr_sign($csr, $rootCa, $rootKey, 3650);

        openssl_x509_export($certificate, $pemCertificate);
        openssl_pkey_export($privateKey, $pemPrivateKey);

        Storage::makeDirectory('certs');

        Storage::put($certificatePath, $pemCertificate);
        Storage::put($keyPath, $pemPrivateKey);
    }

    /**
     * @param $certificatePath
     *
     * @return string
     */
    static public function fingerprintString($certificatePath)
    {
        $fingerpring = openssl_x509_fingerprint(Storage::get($certificatePath), 'sha1');
        return strtoupper(implode(':', str_split($fingerpring, 2)));
    }

    /**
     * @param $certificatePath
     *
     * @return array
     */
    static public function certificateInfo($certificatePath)
    {
        $parsed = openssl_x509_parse(Storage::get($certificatePath));

        return [
            'expires' => Carbon::createFromTimestamp($parsed['validTo_time_t'])->toDateTimeString(),

            'signature_type' => $parsed['signatureTypeSN'],

            'country' => $parsed['subject']['C'] ?? '',
            'state' => $parsed['subject']['ST'] ?? '',
            'locality' => $parsed['subject']['L'] ?? '',
            'organization' => $parsed['subject']['O'] ?? '',
            'organizational_unit' => $parsed['subject']['OU'] ?? '',
            'common_name' => $parsed['subject']['CN'] ?? '',
            'email' => $parsed['subject']['emailAddress'] ?? '',

            'issuer_country' => $parsed['issuer']['C'] ?? '',
            'issuer_state' => $parsed['issuer']['ST'] ?? '',
            'issuer_locality' => $parsed['issuer']['L'] ?? '',
            'issuer_organization' => $parsed['issuer']['O'] ?? '',
            'issuer_organizational_unit' => $parsed['issuer']['OU'] ?? '',
            'issuer_common_name' => $parsed['issuer']['CN'] ?? '',
            'issuer_email' => $parsed['issuer']['emailAddress'] ?? '',
        ];
    }

    /**
     * @param $csrPath
     *
     * @return string
     * @throws GameapException
     */
    static public function signCertificate($csrPath)
    {
        if (!Storage::exists(self::ROOT_CA)) {
            self::generateRoot();
        }

        $rootCa = Storage::get(self::ROOT_CA);
        $rootKey = Storage::get(self::ROOT_KEY);
        
        if (file_exists($csrPath)) {
            $certificate = file_get_contents($csrPath);
            $fromStorage = false;
        } else if (Storage::exists($csrPath)) {
            $certificate = Storage::get($csrPath);
            $fromStorage = true;
        } else {
            throw new GameapException('Invalid csr path');
        }
        
        $signedCertificate = openssl_csr_sign($certificate, $rootCa, $rootKey, 3650);
        openssl_x509_export($signedCertificate, $pemCertificate);

        $pathinfo = pathinfo($csrPath);
        $signedCertificatePath = $pathinfo['dirname'] . '/' . $pathinfo['filename'] . '.crt';
        
        if ($fromStorage) {
            Storage::put($signedCertificatePath, $pemCertificate);
        } else {
            file_put_contents($signedCertificatePath, $pemCertificate);
        }
        
        return $signedCertificatePath;
    }
}