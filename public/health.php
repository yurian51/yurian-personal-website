<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/bootstrap.php';

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

try {
    db()->query('SELECT 1');
    http_response_code(200);
    echo json_encode(
        ['status' => 'ok', 'service' => 'yurian-personal-website', 'database' => 'ok'],
        JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR,
    );
} catch (Throwable $e) {
    error_log('[health] database check failed: ' . get_class($e));
    http_response_code(503);
    echo json_encode(
        ['status' => 'degraded', 'service' => 'yurian-personal-website', 'database' => 'unavailable'],
        JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR,
    );
}
