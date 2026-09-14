<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Register the Composer autoloader...
require __DIR__ . '/../vendor/autoload.php';

// ------------------------------------------------------------------
// Vercel /tmp writable storage — set up on every cold start
// ------------------------------------------------------------------
if (($_ENV['VERCEL'] ?? false) || ($_ENV['NOW_REGION'] ?? false)) {
    $dirs = [
        '/tmp/storage/framework/views',
        '/tmp/storage/framework/cache/data',
        '/tmp/storage/framework/sessions',
        '/tmp/storage/logs',
        '/tmp/storage/app/public',
    ];
    foreach ($dirs as $dir) {
        if (! is_dir($dir)) {
            mkdir($dir, 0775, true);
        }
    }
}

// Bootstrap Laravel...
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Redirect storage path to /tmp so writes succeed on Vercel
if (($_ENV['VERCEL'] ?? false) || ($_ENV['NOW_REGION'] ?? false)) {
    $app->useStoragePath('/tmp/storage');
}

// Handle the request...
$app->handleRequest(Request::capture());