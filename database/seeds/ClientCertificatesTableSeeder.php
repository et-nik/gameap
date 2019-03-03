<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Gameap\Services\CertificateService;

class ClientCertificatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Storage::makeDirectory('client_certificates');

        $timestamp = time();
        $certificateName = "client_certificates/client_{$timestamp}.crt";
        $privateKeyName = "client_certificates/client_{$timestamp}.key";

        CertificateService::generate($certificateName, $privateKeyName);

        DB::table('client_certificates')->insert([
            'certificate' => $certificateName,
            'private_key' => $privateKeyName,
            'private_key_pass' => '',
        ]);
    }
}
