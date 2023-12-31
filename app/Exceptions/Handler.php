<?php

namespace App\Exceptions;

use App\Http\Responses\JsonApiValidationErrorResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

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

    public function render($request, Throwable $e)
    {
        if( $e instanceof AccessDeniedHttpException && $request->wantsJson()){
            return response()->json(["message" => "access denied"], 403);
        }

        if( $e instanceof ModelNotFoundException && $request->wantsJson()){
            return response()->json(["message" => "page not found"], 404);
        }

        return parent::render($request, $e); // TODO: Change the autogenerated stub
    }

    protected function invalidJson($request, ValidationException $exception): JsonApiValidationErrorResponse
    {
        return new JsonApiValidationErrorResponse($exception);
    }

}
