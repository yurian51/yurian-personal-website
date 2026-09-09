#!/bin/sh
set -eu
echo "[startup] waiting for PostgreSQL..."
attempt=1
until php database/migrate.php; do
  if [ "$attempt" -ge 30 ]; then
    echo "[startup] database migration failed after 30 attempts"
    exit 1
  fi
  echo "[startup] database unavailable, retry $attempt/30"
  attempt=$((attempt + 1))
  sleep 2
done
echo "[startup] database ready"
exec apache2-foreground
