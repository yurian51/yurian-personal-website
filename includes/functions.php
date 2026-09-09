<?php
declare(strict_types=1);
function e(?string $value): string { return htmlspecialchars($value??'',ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8'); }
function url(string $path='/'): string { return rtrim(getenv('APP_URL')?:'', '/').'/'.ltrim($path,'/'); }
function csrf_token(): string { return \App\Security\Csrf::token(); }
function verify_csrf(?string $token): bool { return \App\Security\Csrf::verify($token); }
