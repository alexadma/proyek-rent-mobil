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
     * Log every exception BEFORE any rendering attempt.
     * This way even if the 'view' binding is broken we still get
     * the real exception written to stderr / Vercel logs.
     */
    public function report(Throwable $exception): void
    {
        error_log('=== EXCEPTION REPORT ===');
        error_log('Class: ' . get_class($exception));
        error_log('Message: ' . $exception->getMessage());
        error_log('File: ' . $exception->getFile() . ':' . $exception->getLine());
        error_log('Trace: ' . $exception->getTraceAsString());

        parent::report($exception);
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
