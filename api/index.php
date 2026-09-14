<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

require __DIR__ . '/../vendor/autoload.php';

// ------------------------------------------------------------------
// Serverless writable storage — deteksi berdasarkan writability,
// bukan nama platform (lebih reliable di berbagai runtime)
// ------------------------------------------------------------------
$defaultStorage = __DIR__ . '/../storage';
$needsTmpStorage = !is_writable($defaultStorage);

if ($needsTmpStorage) {
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

if ($needsTmpStorage) {
    $app->useStoragePath('/tmp/storage');
}

// Handle the request...
$app->handleRequest(Request::capture());