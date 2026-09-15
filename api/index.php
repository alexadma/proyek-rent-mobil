<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

require __DIR__ . '/../vendor/autoload.php';

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

try {
    $app = require_once __DIR__ . '/../bootstrap/app.php';

    if ($isProduction) {
        $app->useStoragePath('/tmp/storage');
    }

    // DEBUG: Check if key bindings exist before handling request
    $debug = [];
    $debug[] = 'storage_path: ' . $app->storagePath();
    $debug[] = 'APP_ENV: ' . getenv('APP_ENV');
    $debug[] = 'VERCEL: ' . var_export($_ENV['VERCEL'] ?? false, true);

    try {
        $app->make('Illuminate\Contracts\Http\Kernel');
        $debug[] = 'HTTP Kernel: OK';
    } catch (\Throwable $e) {
        $debug[] = 'HTTP Kernel ERROR: ' . $e->getMessage();
    }

    $debug[] = 'Registered providers count: ' . count($app->getLoadedProviders());
    $debug[] = 'Has view binding: ' . var_export($app->bound('view'), true);
    $debug[] = 'Has view.finder binding: ' . var_export($app->bound('view.finder'), true);

    // Write debug to a temp file for Vercel
    file_put_contents('/tmp/storage/debug-bootstrap.txt', implode("\n", $debug));

    $app->handleRequest(Request::capture());

} catch (\Throwable $e) {
    header('Content-Type: text/plain; charset=utf-8');
    http_response_code(500);
    echo "=== FATAL ERROR ===\n";
    echo "Class: " . get_class($e) . "\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";

    // Also try to write to file
    @file_put_contents('/tmp/storage/debug-error.txt',
        get_class($e) . ": " . $e->getMessage() . "\n" .
        $e->getFile() . ":" . $e->getLine() . "\n" .
        $e->getTraceAsString()
    );
    exit;
}