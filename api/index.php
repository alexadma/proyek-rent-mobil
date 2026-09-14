<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

require __DIR__ . '/../vendor/autoload.php';

// ------------------------------------------------------------------
// Serverless writable storage — deteksi via getenv(), lebih reliable
// daripada $_ENV atau is_writable() di environment Vercel
// ------------------------------------------------------------------
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

// Bootstrap Laravel...
$app = require_once __DIR__ . '/../bootstrap/app.php';

if ($isProduction) {
    $app->useStoragePath('/tmp/storage');
}

// Handle the request...
$app->handleRequest(Request::capture());