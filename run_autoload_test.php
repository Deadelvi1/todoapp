<?php
require __DIR__ . '/vendor/autoload.php';
try {
    $m = new \App\Http\Middleware\AuthCheck();
    echo get_class($m) . PHP_EOL;
} catch (Throwable $e) {
    echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
}
