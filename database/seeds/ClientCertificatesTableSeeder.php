<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ClientCertificatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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

        DB::table('client_certificates')->insert([
            'certificate' => $certificateName,
            'private_key' => $privateKeyName,
            'private_key_pass' => '',
        ]);
    }
}
