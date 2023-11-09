<?php

namespace App\Exceptions;

use GuzzleHttp\Exception\TooManyRedirectsException;
use Throwable;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

use Multividas\ApiResponser\Traits\ApiResponser;

class Handler extends ExceptionHandler
{
    use ApiResponser;

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
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (UnauthorizedHttpException $e, $request) {
            return $this->infoResponse("Unauthorized", 401, []);
        });

        $this->renderable(function (AuthenticationException $e, $request) {
            return $this->infoResponse("Unauthenticated", 401, []);
        });

        $this->renderable(function (AccessDeniedHttpException $e, $request) {
            return $this->infoResponse("Access Denied", 403, []);
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            return $this->infoResponse("Resource Not Found", 404, []);
        });

        $this->renderable(function (MethodNotAllowedException $e, $request) {
            return $this->infoResponse('Method Not Allowed', 405, []);
        });

        $this->renderable(function (UnprocessableEntityHttpException $e, $request) {
            return $this->infoResponse('The given data was invalid.', 422, []);
        });

        $this->renderable(function (TooManyRequestsHttpException|TooManyRedirectsException $e, $request) {
            return $this->infoResponse('Too Many Attempts', 429, []);
        });

        $this->renderable(function (HttpException $e, $request) {
            return $this->infoResponse($e->getMessage(), $e->getStatusCode(), []);
        });

        $this->renderable(function (QueryException $e, $request) {
            $errorCode = $e->errorInfo[1];

            if ($errorCode == 1451) {
                return $this->infoResponse('Conflict error', 409, []);
            }
        });

        // other expected exceptions
        $this->renderable(function (Throwable $e, $request) {
            if (config('app.debug')) {
                return $this->infoResponse($e->getMessage(), 500, []);
            }
            return $this->infoResponse("Internal Server Error", 500, []);
        });
    }
}
