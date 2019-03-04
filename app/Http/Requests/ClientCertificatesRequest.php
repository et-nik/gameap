<?php

namespace Gameap\Http\Requests;

use Gameap\Models\ClientCertificate;

class ClientCertificatesRequest extends Request
{
    public function rules()
    {
        return [
            'certificate' => 'required|file',
            'private_key' => 'required|file',
            'private_key_pass' => '',
        ];
    }
}