<?php
declare(strict_types=1);
require_once __DIR__ . '/../config/database.php';
header('Content-Type: application/json');
try {
    db()->query('SELECT 1');
    http_response_code(200);
    echo json_encode(['status'=>'ok','service'=>'yurian-personal-website','database'=>'ok','php'=>PHP_VERSION], JSON_UNESCAPED_SLASHES);
} catch (Throwable $e) {
    http_response_code(503);
    echo json_encode(['status'=>'degraded','service'=>'yurian-personal-website','database'=>'unavailable'], JSON_UNESCAPED_SLASHES);
}
