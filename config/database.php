<?php
declare(strict_types=1);

function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) return $pdo;

    $url = getenv('DATABASE_URL');
    if ($url) {
        $pdo = new PDO($url);
    } else {
        $host = getenv('DB_HOST');
        $name = getenv('DB_NAME');
        $user = getenv('DB_USER');
        $pass = getenv('DB_PASSWORD');
        if (!$host || !$name || !$user) {
            throw new RuntimeException('Database is not configured. Set DATABASE_URL or DB_HOST/DB_NAME/DB_USER/DB_PASSWORD.');
        }
        $dsn = sprintf('pgsql:host=%s;port=%s;dbname=%s', $host, getenv('DB_PORT') ?: '5432', $name);
        $pdo = new PDO($dsn, $user, $pass ?: '');
    }
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
}