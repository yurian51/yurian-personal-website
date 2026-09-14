<?php
declare(strict_types=1);

function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) return $pdo;

    $url = trim((string) getenv('DATABASE_URL'));
    if ($url !== '') {
        $parts = parse_url($url);
        if ($parts !== false && isset($parts['host'], $parts['path'])) {
            $host = $parts['host'];
            $port = $parts['port'] ?? 5432;
            $name = ltrim((string) $parts['path'], '/');
            $user = isset($parts['user']) ? urldecode((string) $parts['user']) : '';
            $pass = isset($parts['pass']) ? urldecode((string) $parts['pass']) : '';
            parse_str((string) ($parts['query'] ?? ''), $query);
            $sslMode = in_array(($query['sslmode'] ?? 'require'), ['disable', 'allow', 'prefer', 'require', 'verify-ca', 'verify-full'], true)
                ? $query['sslmode']
                : 'require';
            if ($user !== '' && $name !== '') {
                return $pdo = new PDO(
                    sprintf('pgsql:host=%s;port=%s;dbname=%s;sslmode=%s', $host, $port, urldecode($name), $sslMode),
                    $user,
                    $pass,
                    [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_TIMEOUT=>10]
                );
            }
        }
    }

    $host = getenv('DB_HOST');
    $name = getenv('DB_NAME');
    $user = getenv('DB_USER');
    $pass = getenv('DB_PASSWORD');
    if (!$host || !$name || !$user) {
        error_log('[database] no runtime database environment variables available');
        throw new RuntimeException('Database configuration is missing.');
    }

    $configuredSslMode = strtolower(trim((string) getenv('DB_SSLMODE')));
    $sslMode = $configuredSslMode !== ''
        ? $configuredSslMode
        : ((getenv('APP_ENV') ?: 'production') === 'production' ? 'require' : 'disable');
    if (!in_array($sslMode, ['disable', 'allow', 'prefer', 'require', 'verify-ca', 'verify-full'], true)) {
        throw new RuntimeException('Invalid DB_SSLMODE configuration.');
    }

    return $pdo = new PDO(
        sprintf('pgsql:host=%s;port=%s;dbname=%s;sslmode=%s', $host, getenv('DB_PORT') ?: '5432', $name, $sslMode),
        $user, $pass ?: '',
        [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_TIMEOUT=>10]
    );
}
