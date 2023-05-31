<?php

namespace App\Exceptions;

use App\Enums\Http;
use App\Helpers\MessageResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
            logger($e->getMessage());
        });
    }
    public function render($request, Throwable $exception)
    {
        $exceptionHandlers = [
            AuthenticationException::class => 'handleAuthenticationException',
            ModelNotFoundException::class => 'handleModelNotFoundException',
            AuthorizationException::class => 'handleAccessDeniedHttpException',

        ];
        $exceptionClass = get_class($exception);
        if (array_key_exists($exceptionClass, $exceptionHandlers) && $request->expectsJson()) {
            $handlerMethod = $exceptionHandlers[$exceptionClass];
            return $this->$handlerMethod($exception);
        }
        return parent::render($request, $exception);
    }
    protected function handleAuthenticationException(AuthenticationException $exception): Responsable
    {
        return new MessageResponse(
            Http::UNAUTHORIZED,
            message: 'Please login first',
            errors: [
                'auth' => ['Please login first'],
            ]
        );
    }
    protected function handleModelNotFoundException(ModelNotFoundException $exception): Responsable
    {
        $model = explode('\\', $exception->getMessage());
        $model = explode(']', last($model));
        return new MessageResponse(
            code: Http::NOT_FOUND,
            message: $model[0] . ' not found.',
            errors: [
                'model' => [
                    $model[0] . ' not found.'
                ]
            ]
        );
    }
    protected function handleAccessDeniedHttpException(AuthorizationException $exception): Responsable
    {
        return new MessageResponse(
            code: Http::FORBIDDEN,
            message: 'You are not authorized to access this resource.',
            errors: [
                'auth' => [
                    'You are not authorized to access this resource.'
                ]
            ]
        );
    }
}
