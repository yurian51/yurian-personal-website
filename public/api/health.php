<?php
declare(strict_types=1);

putenv('SKIP_SESSION_START=1');
require_once __DIR__.'/../../config/bootstrap.php';

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

try {
    db()->query('SELECT 1');
    \App\Http\Response::json([
        'status' => 'ok',
        'service' => 'yurian-personal-website',
        'database' => 'ok',
        'version' => '1.0.0',
        'php' => PHP_VERSION,
    ]);
} catch (Throwable $e) {
    error_log('[api-health] database check failed: '.get_class($e));
    http_response_code(503);
    \App\Http\Response::json([
        'status' => 'degraded',
        'service' => 'yurian-personal-website',
        'database' => 'unavailable',
    ]);
}
