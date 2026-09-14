<?php
declare(strict_types=1);

$root = dirname(__DIR__);
require_once $root . '/includes/functions.php';

function check(bool $condition, string $message): void
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
}

check(PHP_VERSION_ID >= 80300, 'PHP 8.3 or newer is required.');
check(is_dir($root . '/public'), 'public/ must exist.');
check(is_file($root . '/Dockerfile'), 'Dockerfile must exist.');
check(is_file($root . '/public/index.php'), 'Public router must exist.');
check(is_file($root . '/public/assets/css/app.css'), 'Canonical app stylesheet must exist.');
check(is_file($root . '/public/assets/css/hybrid-hq.css'), 'Hybrid HQ stylesheet must exist.');
check(is_file($root . '/public/assets/js/hq.js'), 'Canonical frontend script must exist.');
check(is_file($root . '/public/assets/js/hybrid-hq.js'), 'Hybrid HQ script must exist.');
check(is_dir($root . '/views'), 'Canonical server-side views directory must exist.');
check(is_file($root . '/views/books.php'), 'Book catalog view must exist.');
check(is_file($root . '/views/cart.php'), 'Book cart view must exist.');
check(is_file($root . '/views/checkout.php'), 'Book checkout view must exist.');
check(is_file($root . '/database/migrations/004_bookstore.sql'), 'Bookstore migration must exist.');
check(is_file($root . '/database/migrations/005_security_hardening.sql'), 'Security hardening migration must exist.');
check(!is_file($root . '/public/robots.txt'), 'Static robots.txt must not bypass the canonical router.');
check(!is_file($root . '/public/sitemap.xml'), 'Static sitemap.xml must not bypass the canonical router.');
check(!is_dir($root . '/assets'), 'Root-level assets/ must not be recreated.');
check(!is_dir($root . '/public/views'), 'Duplicate public/views/ must not be recreated.');

$router = file_get_contents($root . '/public/index.php');
check(is_string($router) && str_contains($router, "require __DIR__.'/../views/"), 'Router must load the canonical views directory.');
check(is_string($router) && str_contains($router, "'books'=>"), 'Router must expose the Reading Room.');
check(is_string($router) && str_contains($router, "\$path === 'sitemap.xml'"), 'Router must own sitemap generation.');
check(is_string($router) && str_contains($router, "\$path === 'robots.txt'"), 'Router must own robots generation.');

$bootstrap = file_get_contents($root . '/config/bootstrap.php');
check(is_string($bootstrap) && str_contains($bootstrap, 'X-Content-Type-Options'), 'Security response headers must be configured.');
check(is_string($bootstrap) && str_contains($bootstrap, 'session.use_strict_mode'), 'Strict session mode must be enabled.');
check(is_string($bootstrap) && str_contains($bootstrap, 'session.use_only_cookies'), 'Cookie-only sessions must be enforced.');

$header = file_get_contents($root . '/includes/header.php');
check(is_string($header) && str_contains($header, '/assets/css/hybrid-hq.css'), 'Hybrid HQ CSS must be loaded by the shared header.');
check(is_string($header) && str_contains($header, '/assets/js/hybrid-hq.js'), 'Hybrid HQ JS must be loaded by the shared header.');
check(is_string($header) && str_contains($header, 'knowsAbout'), 'Person structured data must expose knowledge areas.');

$logout = file_get_contents($root . '/admin/logout.php');
check(is_string($logout) && str_contains($logout, "\$_SERVER['REQUEST_METHOD'] !== 'POST'"), 'Admin logout must require POST.');
check(is_string($logout) && str_contains($logout, 'verify_csrf'), 'Admin logout must verify CSRF.');

$database = file_get_contents($root . '/config/database.php');
check(is_string($database) && str_contains($database, 'DB_SSLMODE'), 'Database SSL mode must be configurable.');
check(is_string($database) && str_contains($database, "'production' ? 'require' : 'disable'"), 'Local database connections must not require TLS by default.');

$health = file_get_contents($root . '/health.php');
check(is_string($health) && str_contains($health, "db()->query('SELECT 1')"), 'Health endpoint must verify database readiness.');
check(is_string($health) && str_contains($health, 'http_response_code($healthy ? 200 : 503)'), 'Health endpoint must expose readiness failure as HTTP 503.');

$entrypoint = file_get_contents($root . '/docker/entrypoint.sh');
check(is_string($entrypoint) && str_contains($entrypoint, 'FATAL: database migration failed'), 'Production startup must fail when migrations cannot complete.');
check(is_string($entrypoint) && str_contains($entrypoint, 'FATAL: production requires database configuration'), 'Production startup must require database configuration.');

putenv('APP_URL=https://example.test');
check(url('/books') === 'https://example.test/books', 'Configured APP_URL must produce absolute URLs.');
putenv('APP_URL');

echo "Smoke tests passed.\n";
