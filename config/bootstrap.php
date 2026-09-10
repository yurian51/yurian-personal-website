<?php
declare(strict_types=1);

require_once __DIR__.'/../app/bootstrap.php';
require_once __DIR__.'/database.php';
require_once __DIR__.'/../includes/functions.php';
require_once __DIR__.'/../includes/repository.php';

date_default_timezone_set(getenv('APP_TIMEZONE') ?: 'Africa/Dar_es_Salaam');

if (session_status() === PHP_SESSION_NONE) {
    $forwardedProto = strtolower(trim(explode(',', (string) ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? ''))[0] ?? ''));
    $isSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $forwardedProto === 'https';
    $isProduction = (getenv('APP_ENV') ?: 'production') === 'production';

    ini_set('session.use_strict_mode', '1');
    session_name(getenv('SESSION_NAME') ?: 'yurian_session');
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => $isProduction || $isSecure,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}
