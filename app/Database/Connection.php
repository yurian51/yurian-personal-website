<?php
declare(strict_types=1);
namespace App\Database;
use PDO;
use App\Config\Env;
final class Connection {
 private static ?PDO $pdo=null;
 public static function get(): PDO {
  if(self::$pdo) return self::$pdo;
  $url=Env::get('DATABASE_URL');
  if($url) self::$pdo=new PDO($url);
  else { $host=Env::required('DB_HOST'); $port=Env::get('DB_PORT','5432'); $db=Env::required('DB_NAME'); $user=Env::required('DB_USER'); $pass=Env::get('DB_PASSWORD',''); self::$pdo=new PDO("pgsql:host={$host};port={$port};dbname={$db}",$user,$pass); }
  self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC); self::$pdo->exec("SET TIME ZONE 'UTC'"); return self::$pdo;
 }
}