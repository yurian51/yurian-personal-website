<?php
declare(strict_types=1);

function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) return $pdo;

    $dsn = sprintf(
        'pgsql:host=%s;port=%s;dbname=%s',
        getenv('DB_HOST') ?: 'localhost',
        getenv('DB_PORT') ?: '5432',
        getenv('DB_NAME') ?: 'yurian_personal'
    );

    $pdo = new PDO($dsn, getenv('DB_USER') ?: 'postgres', getenv('DB_PASSWORD') ?: '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
}
