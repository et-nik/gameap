<?php

namespace Gameap\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $token_name
 * @property array $abilities
 */
class GeneratePersonalAccessTokenRequest extends FormRequest
{
    public function rules()
    {
        return [
            'token_name'   => 'required|string',
            'abilities'    => 'required|array',
            'abilities.*'  => 'regex:/^[a-z\-\_\:]+$/i',
        ];
    }

    public function messages()
    {
        return [
            'abilities.required' => __('tokens.validation.abilities_required'),
            'abilities.*.regex'  => __('tokens.validation.abilities_invalid_format'),
        ];
    }
}
