<?php

namespace App\Exceptions;

use App\Helpers\ApiResponse;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Throwable;

class ApiExceptionHandler
{
  public static function bind(Exceptions $exceptions)
  {
    $exceptions->render(function (Throwable $e, Request $request) {
      if ($request->is('api/*')) {

        if($e instanceof ValidationException) {
          return ApiResponse::error($e->getMessage() ?: 'Validation failed', 422, $e->errors());
        }

        if($e instanceof AuthenticationException) {
          return ApiResponse::error('Unauthenticated', 401);
        }

        if($e instanceof AccessDeniedHttpException) {
          return ApiResponse::error('Forbidden', 403);
        }

        if($e instanceof UniqueConstraintViolationException) {
          return ApiResponse::error('Already exists', 403);
        }

        if($e instanceof NotFoundHttpException) {
          return ApiResponse::error('Not found', 404);
        }

        if($e instanceof MethodNotAllowedHttpException) {
          return ApiResponse::error('Method not allowed', 405);
        }

        if($e instanceof ThrottleRequestsException) {
          return ApiResponse::error('Too many requests. Please try again later.', 429);
        }

        return ApiResponse::error(
          config('app.debug') ? $e->getMessage() : 'Something went wrong on the server.',
          500,
          config('app.debug') ? [
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => array_slice($e->getTrace(), 0, 5)
          ] : null
        );
      }
    });
  }
}