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
        '/tmp/bootstrap/cache',
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
        $app->useBootstrapCachePath('/tmp/bootstrap/cache');
    }

    $app->handleRequest(Request::capture());
} catch (\Throwable $e) {
    http_response_code(500);
    echo 'Internal Server Error';
    exit(1);
}
