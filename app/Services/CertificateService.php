<?php

namespace Gameap\Services;

use Gameap\Exceptions\GameapException;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use phpseclib\Crypt\RSA;
use phpseclib\File\X509;

class CertificateService
{
    const ROOT_CA = 'certs/root.crt';
    const ROOT_KEY = 'certs/root.key';

//    const CERT_DN = [
//        "countryName" => "RU",
//        "stateOrProvinceName" => "GameAP",
//        "localityName" => "GameAP",
//        "organizationName" => "GameAP.ru",
//        "organizationalUnitName" => "Development",
//        "commonName" => "GameAP",
//        "emailAddress" => "support@gameap.ru"
//    ];

    const CERT_DN = '/CN=GameAP/O=GameAP';

    const CERT_DAYS = 3650;

    /**
     * Generate root certificate
     */
    static public function generateRoot()
    {
        $privKey = new RSA();
        $keys = $privKey->createKey(2048);
        $privKey->loadKey($keys['privatekey']);

        $pubKey = new RSA();
        $pubKey->loadKey($keys['publickey']);
        $pubKey->setPublicKey();

        $subject = new X509();
        $subject->setDN(self::CERT_DN);
        $subject->setPublicKey($pubKey);

        $issuer = new X509();
        $issuer->setPrivateKey($privKey);
        $issuer->setDN($subject->getDN());

        $x509 = new X509();
        $x509->setEndDate('+10 year');
        $x509->makeCA();

        $result = $x509->sign($issuer, $subject, 'sha256WithRSAEncryption');

        if ($result == false) {
            throw new GameapException('CA Self-signing has failed.');
        }

        Storage::put(self::ROOT_CA, $x509->saveX509($result));
        Storage::put(self::ROOT_KEY, $privKey->getPrivateKey());
    }

    /**
     * @param $certificatePath string   path to certificate in storage
     * @param $keyPath string   path to key in storage
     */
    static public function generate($certificatePath, $keyPath)
    {
        if (!Storage::exists(self::ROOT_CA)) {
            self::generateRoot();
        }

        $privKey = new RSA();
        $keys = $privKey->createKey(2048);
        $privKey->loadKey($keys['privatekey']);

        $pubKey = new RSA();
        $pubKey->loadKey($keys['publickey']);
        $pubKey->setPublicKey();

        // Sign
        $CAPrivKey = new RSA();
        if (! $CAPrivKey->loadKey(Storage::get(self::ROOT_KEY))) {
            throw new GameapException('Failed to load CA Private Key');
        }

        $issuer = new X509();
        $issuer->loadCA(Storage::get(self::ROOT_CA));
        $issuer->loadX509(Storage::get(self::ROOT_CA));
        // $issuer->setDN($CASubject);
        $issuer->setPrivateKey($CAPrivKey);

        $subject = new X509();
        $subject->setDN(self::CERT_DN);
        $subject->setPublicKey($pubKey);

        $x509 = new X509();
        $x509->setEndDate('+10 year');

        $result = $x509->sign($issuer, $subject, 'sha256WithRSAEncryption');
        $result['tbsCertificate']['version'] = 'v1';

        if ($result == false) {
            throw new GameapException('Signing has failed.');
        }

        Storage::put($certificatePath, $x509->saveX509($result));
        Storage::put($keyPath, $privKey->getPrivateKey());
    }

    /**
     * @param $csrPath
     *
     * @return string
     * @throws GameapException
     */
    static public function signCsr($csrPath)
    {
        if (!Storage::exists(self::ROOT_CA)) {
            self::generateRoot();
        }

        $rootCa = Storage::get(self::ROOT_CA);
        $rootKey = Storage::get(self::ROOT_KEY);

        if (file_exists($csrPath)) {
            $csr = file_get_contents($csrPath);
            $fromStorage = false;
        } else if (Storage::exists($csrPath)) {
            $csr = Storage::get($csrPath);
            $fromStorage = true;
        } else {
            throw new GameapException('Invalid csr path');
        }

        $pathinfo = pathinfo($csrPath);
        $signedCertificatePath = $pathinfo['dirname'] . '/' . $pathinfo['filename'] . '.crt';

        $CAPrivKey = new RSA();
        $CAPrivKey->loadKey($rootKey);

        $issuer = new X509();
        $issuer->loadCA($rootCa);
        $issuer->loadX509($rootCa);
        $issuer->setPrivateKey($CAPrivKey);

        $subject = new X509();
        $subject->loadCSR($csr);

        $x509 = new X509();
        $x509->setEndDate('+10 year');

        $result = $x509->sign($issuer, $subject, 'sha256WithRSAEncryption');
        $result['tbsCertificate']['version'] = 'v1';

        if ($result == false) {
            throw new GameapException('Signing has failed.');
        }

        $pemCertificate = $x509->saveX509($result);

        if (empty($pemCertificate)) {
            throw new GameapException('X509 Saving has failed.');
        }

        if ($fromStorage) {
            Storage::put($signedCertificatePath, $pemCertificate);
        } else {
            file_put_contents($signedCertificatePath, $pemCertificate);
        }

        return $signedCertificatePath;
    }

    /**
     * @param $certificatePath
     *
     * @return string
     */
    static public function fingerprintString($certificatePath)
    {
        $fingerprint = openssl_x509_fingerprint(Storage::get($certificatePath), 'sha256');
        return strtoupper(implode(':', str_split($fingerprint, 2)));
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
}