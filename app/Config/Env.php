<?php
declare(strict_types=1);
namespace App\Config;
final class Env {
 public static function get(string $key, ?string $default=null): ?string { $value=getenv($key); return $value===false||$value===''?$default:$value; }
 public static function required(string $key): string { $value=self::get($key); if($value===null) throw new \RuntimeException("Missing required environment variable: {$key}"); return $value; }
}