<?php

namespace App\Helpers;

use App\Exceptions\ValidationResponseException;
use Illuminate\Contracts\Validation\Validator;

trait HandlesValidationResponse
{
    protected function failedValidation(Validator $validator): never
    {
        throw new ValidationResponseException($validator);
    }
}
