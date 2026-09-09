<?php
declare(strict_types=1);
if (PHP_SAPI !== 'cli') exit("CLI only\n");
$password=$argv[1]??'';
if($password==='') exit("Usage: php scripts/hash-password.php 'password'\n");
echo password_hash($password,PASSWORD_DEFAULT).PHP_EOL;
