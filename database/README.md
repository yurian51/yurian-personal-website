# Database

Apply schema.sql first, then migrations in filename order.

Production deployments should use a managed PostgreSQL database and provide DATABASE_URL or DB_* variables through the platform secret manager. Never commit production credentials.
