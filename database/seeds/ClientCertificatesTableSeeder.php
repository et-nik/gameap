<?php

namespace Database\Seeders;

use DB;
use Gameap\Repositories\ClientCertificateRepository;
use Gameap\Services\Daemon\CertificateService;
use Illuminate\Database\Seeder;

class ClientCertificatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timestamp = time();
        $certificateName = ClientCertificateRepository::STORAGE_CERTS_PATH . "/client_{$timestamp}.crt";
        $privateKeyName = ClientCertificateRepository::STORAGE_CERTS_PATH . "/client_{$timestamp}.key";

        CertificateService::generate($certificateName, $privateKeyName);
        $info = CertificateService::certificateInfo($certificateName);

        DB::table('client_certificates')->insert([
            'fingerprint' => CertificateService::fingerprintString($certificateName),
            'expires' => $info['expires'],
            'certificate' => $certificateName,
            'private_key' => $privateKeyName,
            'private_key_pass' => '',
        ]);
    }
}
