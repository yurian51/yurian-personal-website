CREATE TABLE IF NOT EXISTS admin_login_attempts (
    id BIGSERIAL PRIMARY KEY,
    ip_address INET NOT NULL,
    email VARCHAR(255),
    succeeded BOOLEAN NOT NULL DEFAULT FALSE,
    attempted_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

CREATE INDEX IF NOT EXISTS idx_admin_login_attempts_ip_time
    ON admin_login_attempts(ip_address, attempted_at DESC);

CREATE INDEX IF NOT EXISTS idx_admin_login_attempts_email_time
    ON admin_login_attempts(email, attempted_at DESC);
