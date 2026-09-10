# Production deployment

## Recommended hosting path

This repository is containerized for Render-style deployment. The `render.yaml` blueprint creates a Docker web service and a managed PostgreSQL database. It is suitable for a low-traffic production launch and can be upgraded to a paid web plan and database plan without changing the application architecture.

The service listens on port 80 inside the container. Apache serves only `public/`, while server-side templates, configuration, migrations, and application classes stay outside the document root. Render checks `/health.php`; the endpoint returns HTTP 200 only when the application can reach PostgreSQL. This prevents a deployment from being marked healthy while its database is unavailable.

## Deploy from GitHub

In Render, choose **New > Blueprint**, connect `yurian51/yurian-personal-website`, and select the branch to deploy. Render reads `render.yaml`, builds `Dockerfile`, provisions PostgreSQL, and injects `DATABASE_URL`. Set `APP_URL` to the final HTTPS URL shown by Render, for example `https://yurian-personal-website.onrender.com`.

The first boot runs the idempotent migrations with a bounded retry loop. If the database is temporarily unavailable, the container waits and retries rather than failing immediately. Once the service is healthy, verify `/health.php`, `/api/health`, `/`, `/books`, `/cart`, and `/admin/login.php`.

## Environment variables

The production blueprint sets `APP_ENV=production`, `APP_DEBUG=false`, `APP_TIMEZONE=Africa/Dar_es_Salaam`, and a manually configured `APP_URL`. PostgreSQL is supplied through `DATABASE_URL`. Do not commit `.env`, database passwords, payment credentials, or webhook secrets.

If payment integration is enabled later, add its secrets in the hosting dashboard, not in `render.yaml` or Git. The application should use a separate sandbox service and callback URL before live mode is enabled.

## Domain and HTTPS

Add the custom domain in the Render service settings, create the DNS records Render provides, and update `APP_URL` to the canonical HTTPS domain. Keep the Render URL available as a recovery endpoint until the custom domain has passed its TLS and health checks.

## Storage and scaling

The container filesystem is ephemeral. The bookstore currently stores catalog and order data in PostgreSQL and does not depend on local uploads. If the admin later supports cover images or other uploads, use object storage rather than writing files permanently inside the container.

The free plan is appropriate for previews and an early launch but may sleep or have constrained resources. For payment callbacks, time-sensitive checkout, and consistent response latency, use a paid always-available web service and managed PostgreSQL plan. Increase resources only after observing request latency, memory, database connections, and error rate.

## Deployment verification

Run the following before each release:

```bash
find . -type f -name '*.php' -not -path './vendor/*' -print0 | xargs -0 -n1 php -l
php -d zend.assertions=1 -d assert.exception=1 tests/SmokeTest.php
git diff --check
docker build -t yurian-personal-website .
docker run --rm -e APP_ENV=production -p 8080:80 yurian-personal-website
curl -f http://127.0.0.1:8080/health.php
```

After deploy, inspect Render logs for `[startup] Database migrations complete`, open the health endpoint, and test a catalog page. Before merging payment changes, confirm the provider webhook can reach the public HTTPS endpoint and that duplicate webhook delivery is idempotent.

## Rollback

Render keeps previous deploys available. Roll back to the last healthy deploy if the health check fails or error rates increase. Database migrations are forward-only and idempotent; never delete production data as part of a routine rollback.
