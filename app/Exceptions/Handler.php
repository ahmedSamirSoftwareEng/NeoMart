<?php

namespace App\Exceptions;

use GuzzleHttp\Psr7\Query;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Database\QueryException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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

        $this->renderable(function (QueryException $e, $request) {
            if ($e->getCode() == 23000) {
                $message = 'Integrity constraint violation';
            } else {
                $message = $e->getMessage();
            }
            if ($request->expectsJson()) {
                return response()->json(['error' => $message], 400);
            }
            return redirect()->back()->withInput()->with('error', $message);
        });
    }
}
