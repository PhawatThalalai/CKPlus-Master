<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Throwable;
use Illuminate\Http\Request;

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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (AuthenticationException $e, $request) {
            if ($request->is('api/*')) {
                return response('Unauthorized.', 401);
            }
            // หรือให้เรียกใช้เมทอด handleUnauthenticated() ของ Controller หรือ redirect ไปยังหน้า login ของ Web
            // return $this->handleUnauthenticated($request, $e);
        });
    }

    // protected function unauthenticated($request, AuthenticationException $exception)
    // {
    //     if ($request->expectsJson()) {
    //         // Handle the Sanctum exception
    //         if ($exception instanceof UnauthorizedHttpException && $exception->getStatusCode() === 401) {
    //             return response()->json(['error' => 'Unauthorized'], 401);
    //         }

    //         return response()->json(['error' => 'Unauthenticated'], 401);
    //     }

    //     // Redirect to login page for web requests
    //     return redirect()->guest(route('login'));
    // }
}
