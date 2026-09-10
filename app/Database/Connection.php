<?php
declare(strict_types=1);

namespace App\Database;

use App\Config\Env;
use PDO;
use RuntimeException;

final class Connection
{
    private static ?PDO $pdo = null;

    public static function get(): PDO
    {
        if (self::$pdo instanceof PDO) {
            return self::$pdo;
        }

        $dsn = self::dsnFromEnvironment();
        self::$pdo = new PDO(
            $dsn['dsn'],
            $dsn['user'],
            $dsn['password'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_TIMEOUT => 10,
            ],
        );
        self::$pdo->exec("SET TIME ZONE 'UTC'");

        return self::$pdo;
    }

    /** @return array{dsn:string,user:?string,password:?string} */
    private static function dsnFromEnvironment(): array
    {
        $url = Env::get('DATABASE_URL');
        if ($url !== null) {
            $parts = parse_url($url);
            if ($parts === false || empty($parts['host']) || empty($parts['path'])) {
                throw new RuntimeException('DATABASE_URL is invalid.');
            }

            $scheme = $parts['scheme'] ?? 'pgsql';
            if (!in_array($scheme, ['postgres', 'postgresql', 'pgsql'], true)) {
                throw new RuntimeException('DATABASE_URL must use a PostgreSQL scheme.');
            }

            $host = $parts['host'];
            $port = (string) ($parts['port'] ?? 5432);
            $database = ltrim((string) $parts['path'], '/');
            $user = isset($parts['user']) ? urldecode((string) $parts['user']) : null;
            $password = isset($parts['pass']) ? urldecode((string) $parts['pass']) : null;

            return [
                'dsn' => sprintf('pgsql:host=%s;port=%s;dbname=%s;sslmode=require', $host, $port, urldecode($database)),
                'user' => $user,
                'password' => $password,
            ];
        }

        return [
            'dsn' => sprintf(
                'pgsql:host=%s;port=%s;dbname=%s',
                Env::required('DB_HOST'),
                Env::get('DB_PORT', '5432'),
                Env::required('DB_NAME'),
            ),
            'user' => Env::required('DB_USER'),
            'password' => Env::get('DB_PASSWORD', ''),
        ];
    }
}
