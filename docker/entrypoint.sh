#!/bin/sh
set -eu

echo "[startup] booting Yurian Personal Website"

if [ -n "${DATABASE_URL:-}" ] || { [ -n "${DB_HOST:-}" ] && [ -n "${DB_NAME:-}" ] && [ -n "${DB_USER:-}" ]; }; then
  echo "[startup] database configuration detected; running migrations"
  attempt=1
  while ! php database/migrate.php; do
    if [ "$attempt" -ge 30 ]; then
      if [ "${APP_ENV:-production}" = "production" ]; then
        echo "[startup] database migration failed after 30 attempts; refusing to start production web tier" >&2
        exit 1
      fi
      echo "[startup] database migration unavailable after 30 attempts; starting web tier in degraded mode"
      break
    fi
    echo "[startup] database unavailable, retry $attempt/30"
    attempt=$((attempt + 1))
    sleep 2
done
else
  if [ "${APP_ENV:-production}" = "production" ]; then
    echo "[startup] database configuration is missing; refusing to start production web tier" >&2
    exit 1
  fi
  echo "[startup] database configuration is not injected; starting web tier in degraded mode"
fi

exec apache2-foreground
