<?php

namespace App\Exceptions;

use App\Enums\Http;
use App\Helpers\MessageResponse;
use Exception;
use Illuminate\Contracts\Support\Responsable;

class OrderException extends Exception
{

    public function render(): Responsable
    {
        return new MessageResponse(
            code: Http::INTERNAL_SERVER_ERROR,
            message: 'Something went wrong, please try again later.',
            errors: [
                'order' => ['Something went wrong, please try again later.']
            ]
        );
    }
}
