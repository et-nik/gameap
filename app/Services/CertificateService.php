<?php

namespace Gameap\Services;

use Carbon\Carbon;
use Gameap\Exceptions\GameapException;
use Illuminate\Support\Facades\Storage;
use phpseclib\Crypt\RSA;

use Sop\CryptoEncoding\PEM;
use Sop\CryptoTypes\AlgorithmIdentifier\Hash\SHA256AlgorithmIdentifier;
use Sop\CryptoTypes\AlgorithmIdentifier\Signature\SignatureAlgorithmIdentifierFactory;
use Sop\CryptoTypes\Asymmetric\PrivateKeyInfo;
use X501\ASN1\Name;
use X509\Certificate\Certificate;
use X509\Certificate\Extension\BasicConstraintsExtension;
use X509\Certificate\Extension\KeyUsageExtension;
use X509\Certificate\Extension\SubjectKeyIdentifierExtension;
use X509\Certificate\TBSCertificate;
use X509\Certificate\Validity;
use X509\CertificationRequest\CertificationRequest;
use X509\CertificationRequest\CertificationRequestInfo;

class CertificateService
{
    public const ROOT_CA_CERT = 'certs/root.crt';
    public const ROOT_CA_KEY = 'certs/root.key';

    public const PRIVATE_KEY_BITS = 2048;
    
    public const CERT_YEARS = 10;
    
    /**
     * Generate CA root key and certificate.
     * Write root key and certificate to a Storage.
     */
    public static function generateRoot(): void
    {
        $privateKey = (new RSA())->createKey(self::PRIVATE_KEY_BITS)['privatekey'];
        
        $privateKeyInfo = PrivateKeyInfo::fromPEM(PEM::fromString($privateKey));
        
        $publicKeyInfo = $privateKeyInfo->publicKeyInfo();
        
        $name = Name::fromString('CN=GameAP CA, O=GameAP, C=RU');
        
        $validity = Validity::fromStrings('now', 'now + ' . self::CERT_YEARS . ' years');

        // create "to be signed" certificate object with extensions
        $tbsCert = new TBSCertificate($name, $publicKeyInfo, $name, $validity);

        $tbsCert = $tbsCert->withRandomSerialNumber()->withAdditionalExtensions(
            new BasicConstraintsExtension(true, true),
            new SubjectKeyIdentifierExtension(false, $publicKeyInfo->keyIdentifier()),
            new KeyUsageExtension(
                true,
                KeyUsageExtension::DIGITAL_SIGNATURE | KeyUsageExtension::KEY_CERT_SIGN
            )
        );

        // sign certificate with private key
        $algo = SignatureAlgorithmIdentifierFactory::algoForAsymmetricCrypto(
            $privateKeyInfo->algorithmIdentifier(),
            new SHA256AlgorithmIdentifier()
        );

        $cert = $tbsCert->sign($algo, $privateKeyInfo);

        Storage::put(self::ROOT_CA_CERT, $cert);
        Storage::put(self::ROOT_CA_KEY, $privateKey);
    }

    /**
     * Generate key and certificate. Sign certificate
     *
     * @param $certificatePath string   path to certificate in storage
     * @param $keyPath string   path to key in storage
     *
     * @throws GameapException
     */
    public static function generate($certificatePath, $keyPath): void
    {
        if (!Storage::exists(self::ROOT_CA_CERT)) {
            self::generateRoot();
        }

        $privateKey = (new RSA())->createKey(self::PRIVATE_KEY_BITS)['privatekey'];

        $privateKeyInfo = PrivateKeyInfo::fromPEM(
            PEM::fromString($privateKey)
        );

        // extract public key from private key
        $publicKeyInfo = $privateKeyInfo->publicKeyInfo();

        // DN of the subject
        $subject = Name::fromString('CN=' . gethostname() . ', O=GameAP, C=RU');

        // create certification request info
        $cri = new CertificationRequestInfo($subject, $publicKeyInfo);

        // sign certificate request with private key
        $algo = SignatureAlgorithmIdentifierFactory::algoForAsymmetricCrypto(
            $privateKeyInfo->algorithmIdentifier(),
            new SHA256AlgorithmIdentifier()
        );
        
        $csr = $cri->sign($algo, $privateKeyInfo);
        
        $cert = self::signCsr($csr);
        
        Storage::put($certificatePath, $cert);
        Storage::put($keyPath, $privateKey);
    }

    /**
     * @param $csr string   PEM string
     *
     * @return string  PEM certificate
     * @throws GameapException
     */
    public static function signCsr(string $csr)
    {
        if (!Storage::exists(self::ROOT_CA_CERT)) {
            self::generateRoot();
        }

        // load CA's private key
        $privateKeyInfo = PrivateKeyInfo::fromPEM(
            PEM::fromString(Storage::get(self::ROOT_CA_KEY))
        );
        
        $issuerCert = Certificate::fromPEM(
            PEM::fromString(Storage::get(self::ROOT_CA_CERT))
        );
        
        $certificationRequest = CertificationRequest::fromPEM(PEM::fromString($csr));
        
        if (!$certificationRequest->verify()) {
            throw new GameapException('Failed to verify certification request signature.');
        }

        $tbsCert = TBSCertificate::fromCSR($certificationRequest)->withIssuerCertificate($issuerCert);
        
        $tbsCert = $tbsCert->withRandomSerialNumber();
        
        $tbsCert = $tbsCert->withValidity(
            Validity::fromStrings('now', 'now + ' . self::CERT_YEARS . ' years')
        );

        $tbsCert = $tbsCert->withVersion(0);
        
        // sign certificate with issuer's private key
        $algo = SignatureAlgorithmIdentifierFactory::algoForAsymmetricCrypto(
            $privateKeyInfo->algorithmIdentifier(),
            new SHA256AlgorithmIdentifier()
        );

        $cert = $tbsCert->sign($algo, $privateKeyInfo);
        return $cert;
    }

    /**
     * @param $certificatePath
     *
     * @return string
     */
    public static function fingerprintString($certificatePath)
    {
        $fingerprint = openssl_x509_fingerprint(Storage::get($certificatePath), 'sha256');
        return strtoupper(implode(':', str_split($fingerprint, 2)));
    }

    /**
     * @param $certificatePath
     *
     * @return array
     */
    public static function certificateInfo($certificatePath)
    {
        $parsed = openssl_x509_parse(Storage::get($certificatePath));

        return [
            'expires' => Carbon::createFromTimestamp($parsed['validTo_time_t'])->toDateTimeString(),

            'signature_type' => $parsed['signatureTypeSN'],

            'country'             => $parsed['subject']['C'] ?? '',
            'state'               => $parsed['subject']['ST'] ?? '',
            'locality'            => $parsed['subject']['L'] ?? '',
            'organization'        => $parsed['subject']['O'] ?? '',
            'organizational_unit' => $parsed['subject']['OU'] ?? '',
            'common_name'         => $parsed['subject']['CN'] ?? '',
            'email'               => $parsed['subject']['emailAddress'] ?? '',

            'issuer_country'             => $parsed['issuer']['C'] ?? '',
            'issuer_state'               => $parsed['issuer']['ST'] ?? '',
            'issuer_locality'            => $parsed['issuer']['L'] ?? '',
            'issuer_organization'        => $parsed['issuer']['O'] ?? '',
            'issuer_organizational_unit' => $parsed['issuer']['OU'] ?? '',
            'issuer_common_name'         => $parsed['issuer']['CN'] ?? '',
            'issuer_email'               => $parsed['issuer']['emailAddress'] ?? '',
        ];
    }
}
