CREATE TABLE IF NOT EXISTS admin_login_attempts (
    id BIGSERIAL PRIMARY KEY,
    identifier_hash CHAR(64) NOT NULL,
    attempted_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

CREATE INDEX IF NOT EXISTS idx_admin_login_attempts_identifier_time
    ON admin_login_attempts(identifier_hash, attempted_at DESC);

CREATE INDEX IF NOT EXISTS idx_admin_login_attempts_time
    ON admin_login_attempts(attempted_at);
