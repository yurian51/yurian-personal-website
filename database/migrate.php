<?php
declare(strict_types=1);

require_once __DIR__.'/../config/bootstrap.php';

if ((getenv('APP_ENV') ?: 'production') !== 'production') {
    ini_set('display_errors', '1');
}

$pdo = db();
$pdo->exec("SELECT pg_advisory_lock(hashtext('yurian-personal-website:migrations'))");

try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS schema_migrations (version VARCHAR(120) PRIMARY KEY, applied_at TIMESTAMPTZ NOT NULL DEFAULT NOW())");
    $files = glob(__DIR__.'/migrations/*.sql');
    sort($files);

    foreach ($files as $file) {
        $version = basename($file);
        $q = $pdo->prepare('SELECT 1 FROM schema_migrations WHERE version=:v');
        $q->execute([':v' => $version]);
        if ($q->fetchColumn()) {
            continue;
        }

        $sql = file_get_contents($file);
        if ($sql === false) {
            throw new RuntimeException("Unable to read migration: {$version}");
        }

        $pdo->beginTransaction();
        try {
            $pdo->exec($sql);
            $ins = $pdo->prepare('INSERT INTO schema_migrations(version) VALUES(:v)');
            $ins->execute([':v' => $version]);
            $pdo->commit();
            echo "Applied {$version}\n";
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw $e;
        }
    }

    echo "Database migrations complete.\n";
} finally {
    $pdo->exec("SELECT pg_advisory_unlock(hashtext('yurian-personal-website:migrations'))");
}
