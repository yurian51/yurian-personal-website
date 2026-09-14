<?php
declare(strict_types=1);

$root = dirname(__DIR__);
require_once $root . '/includes/functions.php';

assert(PHP_VERSION_ID >= 80300, 'PHP 8.3 or newer is required.');
assert(is_dir($root . '/public'), 'public/ must exist.');
assert(is_file($root . '/Dockerfile'), 'Dockerfile must exist.');
assert(is_file($root . '/public/index.php'), 'Public router must exist.');
assert(is_file($root . '/public/assets/css/app.css'), 'Canonical app stylesheet must exist.');
assert(is_file($root . '/public/assets/css/hybrid-hq.css'), 'Hybrid HQ stylesheet must exist.');
assert(is_file($root . '/public/assets/js/hq.js'), 'Canonical frontend script must exist.');
assert(is_file($root . '/public/assets/js/hybrid-hq.js'), 'Hybrid HQ script must exist.');
assert(is_dir($root . '/views'), 'Canonical server-side views directory must exist.');
assert(is_file($root . '/views/books.php'), 'Book catalog view must exist.');
assert(is_file($root . '/views/cart.php'), 'Book cart view must exist.');
assert(is_file($root . '/views/checkout.php'), 'Book checkout view must exist.');
assert(is_file($root . '/database/migrations/004_bookstore.sql'), 'Bookstore migration must exist.');
assert(is_file($root . '/database/migrations/005_security_hardening.sql'), 'Security hardening migration must exist.');
assert(!is_file($root . '/public/robots.txt'), 'Static robots.txt must not bypass the canonical router.');
assert(!is_file($root . '/public/sitemap.xml'), 'Static sitemap.xml must not bypass the canonical router.');
assert(!is_dir($root . '/assets'), 'Root-level assets/ must not be recreated.');
assert(!is_dir($root . '/public/views'), 'Duplicate public/views/ must not be recreated.');

$router = file_get_contents($root . '/public/index.php');
assert(is_string($router) && str_contains($router, "require __DIR__.'/../views/"), 'Router must load the canonical views directory.');
assert(is_string($router) && str_contains($router, "'books'=>"), 'Router must expose the Reading Room.');
assert(is_string($router) && str_contains($router, "\$path === 'sitemap.xml'"), 'Router must own sitemap generation.');
assert(is_string($router) && str_contains($router, "\$path === 'robots.txt'"), 'Router must own robots generation.');

$bootstrap = file_get_contents($root . '/config/bootstrap.php');
assert(is_string($bootstrap) && str_contains($bootstrap, 'X-Content-Type-Options'), 'Security response headers must be configured.');
assert(is_string($bootstrap) && str_contains($bootstrap, 'session.use_strict_mode'), 'Strict session mode must be enabled.');
assert(is_string($bootstrap) && str_contains($bootstrap, 'session.use_only_cookies'), 'Cookie-only sessions must be enforced.');

$header = file_get_contents($root . '/includes/header.php');
assert(is_string($header) && str_contains($header, '/assets/css/hybrid-hq.css'), 'Hybrid HQ CSS must be loaded by the shared header.');
assert(is_string($header) && str_contains($header, '/assets/js/hybrid-hq.js'), 'Hybrid HQ JS must be loaded by the shared header.');
assert(is_string($header) && str_contains($header, 'knowsAbout'), 'Person structured data must expose knowledge areas.');

putenv('APP_URL=https://example.test');
assert(url('/books') === 'https://example.test/books', 'Configured APP_URL must produce absolute URLs.');
putenv('APP_URL');

echo "Smoke tests passed.\n";
