# Yurian Personal Website

Production-ready personal brand website built with PHP 8.3, PostgreSQL, Docker, Apache, and Render.

## Stack

- PHP 8.3 with PDO PostgreSQL
- PostgreSQL 16+ (Render uses the configured managed database)
- Apache in the official PHP 8.3 image
- HTML5, CSS3, and vanilla JavaScript
- Docker Compose for local development
- Render for production deployment

## Repository structure

```text
public/       Apache document root, routes, browser assets, and APIs
views/        Server-side page templates loaded by public/index.php
admin/        Protected CMS login and dashboard
app/          Backend application services, repositories, security, and HTTP helpers
config/       Runtime bootstrap and database configuration
includes/     Shared presentation helpers and repository functions
database/     Idempotent migrations, schema reference, and database documentation
tests/        Smoke and structural checks
docker/       Apache and container startup configuration
```

### Frontend source of truth

The browser-facing source is intentionally split by delivery responsibility:

- `public/assets/` is the only official location for CSS, JavaScript, and images.
- `views/` is the only official location for server-side page templates. The router loads it explicitly from `public/index.php`.
- Root-level `assets/` and `public/views/` are intentionally absent; do not recreate them.
- `app/` is backend code, not a frontend asset directory.

This layout keeps executable PHP templates outside the Apache document root while keeping static assets directly cacheable by the web server.

## Reading Room bookstore

The HQ now includes a lightweight book-selling mini app:

- `/books` — published catalog
- `/books/{slug}` — book detail page
- `/cart` — session-backed cart with stock-aware quantities
- `/checkout` — customer inquiry form

Checkout intentionally stops at an **order inquiry**. It stores the requested titles and customer details in PostgreSQL, then the team confirms availability, delivery, and payment manually. No payment is captured by the website yet.

The bookstore schema and seed catalog live in `database/migrations/004_bookstore.sql` and are applied automatically by the migration runner.

## Local development

1. Copy `.env.example` to `.env`.
2. Start the stack:

   ```bash
   docker compose up --build
   ```

3. Open <http://localhost:8080>.
4. Run the local checks:

   ```bash
   docker compose exec app php tests/SmokeTest.php
   ```

The application can render fallback content when a database is unavailable, but contact submissions, admin login, book inquiries, and database-backed APIs require PostgreSQL.

## Database migrations

The container startup runs `database/migrate.php` when database environment variables are available. Migrations are tracked in `schema_migrations` and are applied in filename order, once each. Add new changes as a new numbered migration; do not edit an already-applied migration in place.

## Production

Deploy as a Docker Web Service on Render and attach the configured PostgreSQL database. The application accepts Render's `DATABASE_URL` and also supports separate `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, and `DB_PASSWORD` variables. Never commit production secrets.

The production health endpoint is `/health.php`. The public API endpoints are `/api/health` and `/api/projects`.

## Validation checklist

Before merging a change:

```bash
find . -type f -name '*.php' -not -path './vendor/*' -print0 | xargs -0 -n1 php -l
php -d zend.assertions=1 -d assert.exception=1 tests/SmokeTest.php
git diff --check
```

When Docker is available, also run:

```bash
docker build -t yurian-personal-website .
docker compose config
```

Verify `/`, `/projects`, `/blog`, `/books`, `/cart`, `/contact`, `/admin/login.php`, `/api/health`, and `/api/projects` after starting the container.

## Additional hardening completed

The current branch also includes bounded database query limits, secure session cookies, Render-compatible database URL parsing, safe JSON response encoding, absolute URL fallback generation, stricter security headers, static asset caching, structural CI guardrails, and transactional book-order persistence.

## Deployment and hosting

The repository includes a Render-compatible Docker blueprint in `render.yaml`, a production PHP configuration in `docker/php.ini`, a Docker health probe, and a detailed deployment runbook in [`docs/deployment.md`](docs/deployment.md). The service serves only `public/`, runs idempotent migrations during startup, checks PostgreSQL through `/health.php`, and keeps production secrets in the hosting provider's environment settings.

The default free plan is useful for previews and an early launch. For payment callbacks, consistent latency, and a business-critical storefront, use an always-available paid web service and managed database plan. The app is stateless apart from PostgreSQL, so it can be scaled without relying on local container storage.
