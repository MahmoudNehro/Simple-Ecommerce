<?php

namespace App\Exceptions;

use App\Enums\Http;
use App\Helpers\MessageResponse;
use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\Validation\Validator;

class ValidationResponseException extends Exception
{
    public function __construct(
        public Validator $validator
    ) {
    }

    public function render(): Responsable
    {
        return new MessageResponse(
            code: Http::UNPROCESSABLE_ENTITY,
            message: 'The given data was invalid.',
            body: [],
            errors: $this->validator?->getMessageBag()?->toArray()
        );
    }
}
