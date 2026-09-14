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

$app = require_once __DIR__ . '/../bootstrap/app.php';

if ($isProduction) {
    $app->useStoragePath('/tmp/storage');
}

$app->handleRequest(Request::capture());