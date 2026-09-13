<?php
declare(strict_types=1);

$root = dirname(__DIR__);
require_once $root . '/includes/functions.php';

assert(PHP_VERSION_ID >= 80300, 'PHP 8.3 or newer is required.');
assert(is_dir($root . '/public'), 'public/ must exist.');
assert(is_file($root . '/Dockerfile'), 'Dockerfile must exist.');
assert(is_file($root . '/public/index.php'), 'Public router must exist.');
assert(is_file($root . '/public/health.php'), 'Production health endpoint must exist.');
assert(is_file($root . '/public/assets/css/app.css'), 'Canonical app stylesheet must exist.');
assert(is_file($root . '/public/assets/css/institutional.css'), 'Institutional stylesheet must exist.');
assert(is_file($root . '/public/assets/js/hq.js'), 'Canonical frontend script must exist.');
assert(is_dir($root . '/views'), 'Canonical server-side views directory must exist.');
assert(is_file($root . '/views/books.php'), 'Book catalog view must exist.');
assert(is_file($root . '/views/cart.php'), 'Book cart view must exist.');
assert(is_file($root . '/views/checkout.php'), 'Book checkout view must exist.');
assert(is_file($root . '/database/migrations/004_bookstore.sql'), 'Bookstore migration must exist.');
assert(is_file($root . '/database/migrations/005_security.sql'), 'Security migration must exist.');
assert(is_file($root . '/database/migrations/006_schema_compatibility.sql'), 'Schema compatibility migration must exist.');
assert(is_file($root . '/database/migrations/007_data_integrity.sql'), 'Data integrity migration must exist.');
assert(!is_file($root . '/health.php'), 'Unreachable root health endpoint must not return.');
assert(!is_dir($root . '/assets'), 'Root-level assets/ must not be recreated.');
assert(!is_dir($root . '/public/views'), 'Duplicate public/views/ must not be recreated.');

$router = file_get_contents($root . '/public/index.php');
assert(is_string($router) && str_contains($router, "require __DIR__.'/../views/"), 'Router must load the canonical views directory.');
assert(is_string($router) && str_contains($router, "'books'=>"), 'Router must expose the Reading Room.');

$header = file_get_contents($root . '/includes/header.php');
assert(is_string($header) && str_contains($header, '/assets/css/institutional.css'), 'Shared header must load the institutional stylesheet.');
assert(is_string($header) && str_contains($header, 'YURIAN <b>//</b> TECHNOLOGY'), 'Shared header must use the institutional brand.');
assert(is_string($header) && str_contains($header, 'aria-controls="primary-navigation"'), 'Mobile navigation must expose its controlled target.');
assert(is_string($header) && str_contains($header, 'aria-expanded="false"'), 'Mobile navigation must expose its initial expanded state.');
assert(is_string($header) && str_contains($header, 'href="#main-content"'), 'Shared header must expose a skip-to-content link.');

$footer = file_get_contents($root . '/includes/footer.php');
assert(is_string($footer) && str_contains($footer, 'Portfolio'), 'Footer must expose the portfolio route.');
assert(is_string($footer) && str_contains($footer, 'Publications'), 'Footer must expose the publications route.');
assert(is_string($footer) && str_contains($footer, 'Insights'), 'Footer must expose the insights route.');
assert(is_string($footer) && str_contains($footer, 'Privacy'), 'Footer must expose the privacy route.');

$frontend = file_get_contents($root . '/public/assets/js/hq.js');
assert(is_string($frontend) && str_contains($frontend, 'setNavOpen'), 'Frontend must implement mobile navigation state.');
assert(is_string($frontend) && str_contains($frontend, "navToggle.setAttribute('aria-expanded'"), 'Frontend must synchronize navigation accessibility state.');
assert(is_string($frontend) && str_contains($frontend, "event.key === 'Escape'"), 'Frontend must close overlays and navigation on Escape.');

$home = file_get_contents($root . '/views/home.php');
assert(is_string($home) && str_contains($home, 'data-github-activity'), 'Homepage must retain the public GitHub activity integration.');
assert(is_string($home) && str_contains($home, '/projects'), 'Homepage must retain project navigation.');

$health = file_get_contents($root . '/public/health.php');
assert(is_string($health) && str_contains($health, "putenv('SKIP_SESSION_START=1');"), 'Health endpoint must not create application sessions.');
assert(is_string($health) && str_contains($health, "require_once __DIR__ . '/../config/bootstrap.php';"), 'Health endpoint must load the application bootstrap.');
assert(is_string($health) && str_contains($health, "header('Cache-Control: no-store');"), 'Health endpoint must not be cached.');

$apiHealth = file_get_contents($root . '/public/api/health.php');
assert(is_string($apiHealth) && str_contains($apiHealth, "putenv('SKIP_SESSION_START=1');"), 'API health endpoint must not create application sessions.');
assert(is_string($apiHealth) && str_contains($apiHealth, "db()->query('SELECT 1')"), 'API health endpoint must verify database readiness.');
assert(is_string($apiHealth) && str_contains($apiHealth, "http_response_code(503)"), 'API health endpoint must expose degraded status when the database is unavailable.');

$migrate = file_get_contents($root . '/database/migrate.php');
assert(is_string($migrate) && str_contains($migrate, 'pg_advisory_lock'), 'Migration runner must serialize concurrent migration attempts.');
assert(is_string($migrate) && str_contains($migrate, 'Unable to read migration'), 'Migration runner must fail explicitly when a migration file cannot be read.');

$dataIntegrity = file_get_contents($root . '/database/migrations/007_data_integrity.sql');
assert(is_string($dataIntegrity) && str_contains($dataIntegrity, "currency ~ '^[A-Z]{3}$'"), 'Currency fields must be constrained to ISO-like three-letter uppercase codes.');

$projectView = file_get_contents($root . '/views/project.php');
assert(is_string($projectView) && str_contains($projectView, 'safe_link'), 'Project view must validate external project links.');
assert(is_string($projectView) && str_contains($projectView, 'noopener noreferrer'), 'External project links must prevent opener access.');

$logout = file_get_contents($root . '/admin/logout.php');
assert(is_string($logout) && str_contains($logout, "$_SERVER['REQUEST_METHOD'] !== 'POST'"), 'Admin logout must require POST.');
assert(is_string($logout) && str_contains($logout, 'verify_csrf'), 'Admin logout must verify CSRF.');

putenv('APP_URL=https://example.test');
assert(url('/books') === 'https://example.test/books', 'Configured APP_URL must produce absolute URLs.');
putenv('APP_URL');

assert(safe_link('/projects/example') === '/projects/example', 'Relative project links must remain supported.');
assert(safe_link('//evil.example/project') === null, 'Protocol-relative external links must be rejected.');
assert(safe_link('https://example.test/project') === 'https://example.test/project', 'HTTPS project links must be supported.');
assert(safe_link('https://user:password@example.test/project') === null, 'Credential-bearing external links must be rejected.');
assert(safe_link('javascript:alert(1)') === null, 'Unsafe javascript links must be rejected.');
assert(safe_link('data:text/html,test') === null, 'Unsafe data links must be rejected.');
assert(e('<script>') === '&lt;script&gt;', 'HTML escaping must remain enabled.');

echo "Smoke tests passed.\n";
