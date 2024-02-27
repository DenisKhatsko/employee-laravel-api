<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
     * @throws Throwable
     */
    public function register(): void
    {
        $this->renderable(function (ModelNotFoundException|NotFoundHttpException $e, $request) {
            if ($request->wantsJson() || $request->is('api/*')) {
                Log::channel('api')->error($e->getMessage());
                return response()->not_found();
            }

        });

    }
    public function render($request, Exception|Throwable $e)
    {
        return parent::render($request, $e);
    }
}
