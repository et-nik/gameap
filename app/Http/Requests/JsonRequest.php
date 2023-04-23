<?php

namespace Gameap\Http\Requests;

use Gameap\Exceptions\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Response;
use Illuminate\Validation\Factory;

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
        /** @var Factory $factory */
        $factory = $this->container->make(Factory::class);

        if (method_exists($this, 'validator')) {
            return $this->container->call([$this, 'validator'], compact('factory'));
        }

        $data = $this->json->all();

        if (empty($data)) {
            $data = $this->request->all();
        }

        return $factory->make(
            $data,
            $this->container->call([$this, 'rules']),
            $this->messages(),
            $this->attributes()
        );
    }
}
