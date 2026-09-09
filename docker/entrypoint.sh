#!/bin/sh
set -u
echo "[startup] booting Yurian Personal Website"
if [ -n "${DATABASE_URL:-}" ] || { [ -n "${DB_HOST:-}" ] && [ -n "${DB_NAME:-}" ] && [ -n "${DB_USER:-}" ]; }; then
  echo "[startup] database configuration detected; running migrations"
  attempt=1
  while ! php database/migrate.php; do
    if [ "$attempt" -ge 30 ]; then
      echo "[startup] database migration unavailable after 30 attempts; starting web tier in degraded mode"
      break
    fi
    echo "[startup] database unavailable, retry $attempt/30"
    attempt=$((attempt + 1))
    sleep 2
  done
else
  echo "[startup] database configuration is not injected; starting web tier in degraded mode"
fi
exec apache2-foreground
