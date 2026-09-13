<?php
declare(strict_types=1);

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function url(string $path = '/'): string
{
    $configured = trim((string) getenv('APP_URL'));
    if ($configured !== '') {
        return rtrim($configured, '/') . '/' . ltrim($path, '/');
    }

    $forwardedProto = strtolower(trim(explode(',', (string) ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? ''))[0] ?? ''));
    $scheme = $forwardedProto === 'https' || (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        ? 'https'
        : 'http';
    $host = trim((string) ($_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? 'localhost'));
    $host = preg_replace('/[^a-zA-Z0-9.\-:\[\]]/', '', $host) ?: 'localhost';

    return $scheme . '://' . $host . '/' . ltrim($path, '/');
}

function safe_link(?string $candidate): ?string
{
    $candidate = trim((string) $candidate);
    if ($candidate === '') return null;
    if (str_starts_with($candidate, '/')) return $candidate;
    if (!filter_var($candidate, FILTER_VALIDATE_URL)) return null;
    $scheme = strtolower((string) parse_url($candidate, PHP_URL_SCHEME));
    return in_array($scheme, ['https', 'http'], true) ? $candidate : null;
}

function csrf_token(): string
{
    return \App\Security\Csrf::token();
}

function verify_csrf(?string $token): bool
{
    return \App\Security\Csrf::verify($token);
}
