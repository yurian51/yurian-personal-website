<?php
declare(strict_types=1);

function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) return $pdo;

    $url = trim((string) getenv('DATABASE_URL'));
    $url = trim($url, " \\t\\r\\n\\\"");
    if (str_starts_with($url, 'postgres://')) $url = 'postgresql://' . substr($url, 11);

    if ($url !== '') {
        $parts = parse_url($url);
        if ($parts === false || empty($parts['host']) || empty($parts['path'])) {
            if (!preg_match('~^postgres(?:ql)?://(?:(.*?):(.*?)@)?([^:/?#]+)(?::(\\d+))?/([^?]+)~', $url, $m)) {
                throw new RuntimeException('Invalid DATABASE_URL format.');
            }
            $parts = [
                'host' => $m[3],
                'port' => $m[4] ?? 5432,
                'path' => '/' . $m[5],
                'user' => $m[1] ?? '',
                'pass' => $m[2] ?? '',
            ];
        }

        $host = $parts['host'];
        $port = $parts['port'] ?? 5432;
        $name = ltrim((string) $parts['path'], '/');
        $user = isset($parts['user']) ? urldecode((string) $parts['user']) : '';
        $pass = isset($parts['pass']) ? urldecode((string) $parts['pass']) : '';

        if ($user === '' || $name === '') {
            throw new RuntimeException('DATABASE_URL is missing database credentials.');
        }

        $dsn = sprintf(
            'pgsql:host=%s;port=%s;dbname=%s;sslmode=require',
            $host,
            $port,
            urldecode($name)
        );
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_TIMEOUT => 10,
        ]);
        return $pdo;
    }

    $host = getenv('DB_HOST');
    $name = getenv('DB_NAME');
    $user = getenv('DB_USER');
    $pass = getenv('DB_PASSWORD');

    if (!$host || !$name || !$user) {
        throw new RuntimeException('Database is not configured. Set DATABASE_URL or DB_HOST/DB_NAME/DB_USER/DB_PASSWORD.');
    }

    $dsn = sprintf('pgsql:host=%s;port=%s;dbname=%s;sslmode=require', $host, getenv('DB_PORT') ?: '5432', $name);
    $pdo = new PDO($dsn, $user, $pass ?: '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_TIMEOUT => 10,
    ]);
    return $pdo;
}
