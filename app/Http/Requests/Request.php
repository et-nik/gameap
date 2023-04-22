<?php

namespace Gameap\Http\Requests;

use Gameap\Exceptions\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    /**
     * Authorization
     *
     * @return boolean
     */
    public function authorize()
    {
        return true;
    }
}
