<?php
declare(strict_types=1);
require_once __DIR__.'/../config/bootstrap.php';
$pdo=db();
$pdo->exec("CREATE TABLE IF NOT EXISTS schema_migrations (version VARCHAR(120) PRIMARY KEY, applied_at TIMESTAMPTZ NOT NULL DEFAULT NOW())");
$files=glob(__DIR__.'/migrations/*.sql'); sort($files);
foreach($files as $file){$version=basename($file);$q=$pdo->prepare('SELECT 1 FROM schema_migrations WHERE version=:v');$q->execute([':v'=>$version]);if($q->fetchColumn())continue;$sql=file_get_contents($file);$pdo->beginTransaction();try{$pdo->exec($sql);$ins=$pdo->prepare('INSERT INTO schema_migrations(version) VALUES(:v)');$ins->execute([':v'=>$version]);$pdo->commit();echo "Applied {$version}\n";}catch(Throwable $e){$pdo->rollBack();throw $e;}}
echo "Database migrations complete.\n";
