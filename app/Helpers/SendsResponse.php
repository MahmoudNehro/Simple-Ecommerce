<?php

namespace App\Helpers;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait SendsResponse
{
    public function toResponse($request): Response
    {
        $data = [
            'code' => $this->code->value,
            'message' => $this->message,
            'body' => (object) $this->body,
            'errors' => (object) $this->errors,
        ];
        return new JsonResponse(
            data: $data,
            status: $this->code->value,
        );
    }
}
