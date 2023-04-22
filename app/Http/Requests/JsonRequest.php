<?php

namespace Gameap\Http\Requests;

use Gameap\Exceptions\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Response;

abstract class JsonRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function failedValidation(Validator $validator): void
    {
        throw new ValidationException(implode(', ', $validator->errors()->all()), Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Get the validator instance for the request.
     *
     * @return \Illuminate\Validation\Validator
     */
    protected function getValidatorInstance()
    {
        $factory = $this->container->make('Illuminate\Validation\Factory');

        if (method_exists($this, 'validator')) {
            return $this->container->call([$this, 'validator'], compact('factory'));
        }

        return $factory->make(
            $this->json()->all(),
            $this->container->call([$this, 'rules']),
            $this->messages(),
            $this->attributes()
        );
    }
}
