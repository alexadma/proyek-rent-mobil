<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

require __DIR__ . '/../vendor/autoload.php';

// ------------------------------------------------------------------
// TEMPORARY DEBUG WRAPPER — tangkap semua error/exception secara
// manual dan tampilkan sebagai teks polos, terlepas dari APP_DEBUG
// ------------------------------------------------------------------
set_error_handler(function ($severity, $message, $file, $line) {
    throw new \ErrorException($message, 0, $severity, $file, $line);
});

try {
    $isProduction = getenv('APP_ENV') === 'production';

    if ($isProduction) {
        $dirs = [
            '/tmp/storage/framework/views',
            '/tmp/storage/framework/cache/data',
            '/tmp/storage/framework/sessions',
            '/tmp/storage/logs',
            '/tmp/storage/app/public',
        ];
        foreach ($dirs as $dir) {
            if (!is_dir($dir)) {
                mkdir($dir, 0775, true);
            }
        }
    }

    $app = require_once __DIR__ . '/../bootstrap/app.php';

    if ($isProduction) {
        $app->useStoragePath('/tmp/storage');
    }

    $app->handleRequest(Request::capture());

} catch (\Throwable $e) {
    header('Content-Type: text/plain; charset=utf-8');
    http_response_code(500);
    echo "=== DEBUG CATCH ===\n";
    echo "Class: " . get_class($e) . "\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
    exit;
}