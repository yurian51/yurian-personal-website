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

The application can render fallback content when a database is unavailable, but contact submissions, admin login, and database-backed APIs require PostgreSQL.

## Database migrations

The container startup runs `database/migrate.php` when database environment variables are available. Migrations are tracked in `schema_migrations` and are applied in filename order, once each. Add new changes as a new numbered migration; do not edit an already-applied migration in place.

## Production

Deploy as a Docker Web Service on Render and attach the configured PostgreSQL database. The application accepts Render's `DATABASE_URL` and also supports separate `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, and `DB_PASSWORD` variables. Never commit production secrets.

The production health endpoint is `/health.php`. The public API endpoints are `/api/health` and `/api/projects`.

## Validation checklist

Before merging a change:

```bash
find . -type f -name '*.php' -not -path './vendor/*' -print0 | xargs -0 -n1 php -l
php tests/SmokeTest.php
```

When Docker is available, also run:

```bash
docker build -t yurian-personal-website .
docker compose config
```

Verify `/`, `/projects`, `/blog`, `/contact`, `/admin/login.php`, `/api/health`, and `/api/projects` after starting the container.
