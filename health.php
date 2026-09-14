<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

$healthy = true;
$dbStatus = 'unconfigured';

try {
    require_once __DIR__.'/config/bootstrap.php';
    db()->query('SELECT 1');
    $dbStatus = 'ok';
} catch (Throwable $e) {
    $healthy = false;
    $dbStatus = 'unavailable';
    error_log('[health] database check failed: '.$e->getMessage());
}

http_response_code($healthy ? 200 : 503);
echo json_encode([
    'status' => $healthy ? 'ok' : 'degraded',
    'service' => 'yurian-personal-website',
    'php' => PHP_VERSION,
    'database' => $dbStatus,
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
