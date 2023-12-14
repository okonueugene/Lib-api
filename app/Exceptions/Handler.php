<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
        });


    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof TokenMismatchException) {
            return response()->json(['message' => 'Token mismatch exception'], 500);
        }

        if ($exception instanceof NotFoundHttpException) {
            return response()->json(['message' => 'Not found exception'], 500);

        }

        if ($exception instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {
            $this->renderable(function (\Spatie\Permission\Exceptions\UnauthorizedException $e, $request) {
                return response()->json(['message' => 'Unauthorized exception you do not have permission for this resource'], 403);
            });
        }


        return parent::render($request, $exception);
    }

}