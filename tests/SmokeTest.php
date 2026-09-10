<?php
declare(strict_types=1);

$root = dirname(__DIR__);
require_once $root . '/includes/functions.php';

assert(PHP_VERSION_ID >= 80300, 'PHP 8.3 or newer is required.');
assert(is_dir($root . '/public'), 'public/ must exist.');
assert(is_file($root . '/Dockerfile'), 'Dockerfile must exist.');
assert(is_file($root . '/public/index.php'), 'Public router must exist.');
assert(is_file($root . '/public/assets/css/app.css'), 'Canonical app stylesheet must exist.');
assert(is_file($root . '/public/assets/js/hq.js'), 'Canonical frontend script must exist.');
assert(is_dir($root . '/views'), 'Canonical server-side views directory must exist.');
assert(is_file($root . '/views/books.php'), 'Book catalog view must exist.');
assert(is_file($root . '/views/cart.php'), 'Book cart view must exist.');
assert(is_file($root . '/views/checkout.php'), 'Book checkout view must exist.');
assert(is_file($root . '/database/migrations/004_bookstore.sql'), 'Bookstore migration must exist.');
assert(!is_dir($root . '/assets'), 'Root-level assets/ must not be recreated.');
assert(!is_dir($root . '/public/views'), 'Duplicate public/views/ must not be recreated.');

$router = file_get_contents($root . '/public/index.php');
assert(is_string($router) && str_contains($router, "require __DIR__.'/../views/"), 'Router must load the canonical views directory.');
assert(is_string($router) && str_contains($router, "'books'=>"), 'Router must expose the Reading Room.');

putenv('APP_URL=https://example.test');
assert(url('/books') === 'https://example.test/books', 'Configured APP_URL must produce absolute URLs.');
putenv('APP_URL');

echo "Smoke tests passed.\n";
