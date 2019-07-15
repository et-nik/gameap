<?php

namespace Gameap\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ServerDestroyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'delete_files' => 'nullable',
        ];
    }
}
