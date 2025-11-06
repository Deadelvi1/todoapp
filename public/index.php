<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap the application
/** @var \Illuminate\Foundation\Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

// Use the HTTP kernel to handle the incoming request. This is the standard
// flow used by Laravel and ensures middleware and exception handling run
// correctly.
try {
    $request = Request::capture();

    $kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

    $response = $kernel->handle($request);
    $response->send();

    $kernel->terminate($request, $response);
} catch (Throwable $e) {
    // In case something goes wrong during bootstrap/handling, display a
    // detailed error when APP_DEBUG is true, otherwise log and show a
    // simple 500 page.
    if (env('APP_DEBUG', false)) {
        echo "<h1>Application Error</h1>";
        echo "<pre>" . htmlspecialchars((string) $e) . "</pre>";
    } else {
        http_response_code(500);
        echo "<h1>Internal Server Error</h1>";
    }

    // Attempt to report the exception via the container if possible.
    if (isset($app) && method_exists($app, 'make')) {
        try {
            $reporter = $app->has('\\Psr\\Log\\LoggerInterface') ? $app->make('Psr\\Log\\LoggerInterface') : null;
            if ($reporter) {
                $reporter->error('Unhandled exception in public/index.php', ['exception' => $e]);
            }
        } catch (Throwable $reportEx) {
            // ignore
        }
    }
}
