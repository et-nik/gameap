<?php

namespace Gameap\Http\Requests;

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