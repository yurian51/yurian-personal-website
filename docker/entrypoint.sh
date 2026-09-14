#!/bin/sh
set -eu

echo "[startup] booting Yurian Personal Website"

if [ -n "${DATABASE_URL:-}" ] || { [ -n "${DB_HOST:-}" ] && [ -n "${DB_NAME:-}" ] && [ -n "${DB_USER:-}" ]; }; then
  echo "[startup] database configuration detected; running migrations"
  attempt=1
  while ! php database/migrate.php; do
    if [ "$attempt" -ge 30 ]; then
      echo "[startup] FATAL: database migration failed after 30 attempts; refusing to start web tier"
      exit 1
    fi
    echo "[startup] database unavailable or migration failed, retry $attempt/30"
    attempt=$((attempt + 1))
    sleep 2
  done
  echo "[startup] database migrations verified"
elif [ "${APP_ENV:-production}" = "production" ]; then
  echo "[startup] FATAL: production requires database configuration"
  exit 1
else
  echo "[startup] database configuration is not injected; starting local web tier without database"
fi

exec apache2-foreground
