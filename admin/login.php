<?php
declare(strict_types=1);
require_once __DIR__.'/../config/bootstrap.php';

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['_csrf'] ?? null)) {
        $error = 'Invalid security token.';
    } else {
        $email = strtolower(trim((string)($_POST['email'] ?? '')));
        $password = (string)($_POST['password'] ?? '');
        $identifierHash = hash('sha256', $email);
        $pdo = db();

        $cleanup = $pdo->prepare("DELETE FROM admin_login_attempts WHERE attempted_at < NOW() - INTERVAL '1 day'");
        $cleanup->execute();

        $attempts = $pdo->prepare("SELECT COUNT(*) FROM admin_login_attempts WHERE identifier_hash = :hash AND attempted_at >= NOW() - INTERVAL '15 minutes'");
        $attempts->execute([':hash' => $identifierHash]);

        if ((int)$attempts->fetchColumn() >= 5) {
            $error = 'Too many sign-in attempts. Please wait 15 minutes and try again.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
            $error = 'Invalid credentials.';
        } else {
            $s = $pdo->prepare('SELECT * FROM admins WHERE email=:email LIMIT 1');
            $s->execute([':email' => $email]);
            $admin = $s->fetch();

            if ($admin && password_verify($password, $admin['password_hash'])) {
                $clear = $pdo->prepare('DELETE FROM admin_login_attempts WHERE identifier_hash = :hash');
                $clear->execute([':hash' => $identifierHash]);
                session_regenerate_id(true);
                unset($_SESSION['_csrf']);
                $_SESSION['admin_id'] = $admin['id'];
                header('Location:/admin/');
                exit;
            }

            $record = $pdo->prepare('INSERT INTO admin_login_attempts(identifier_hash) VALUES(:hash)');
            $record->execute([':hash' => $identifierHash]);
            $error = 'Invalid credentials.';
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="robots" content="noindex,nofollow">
<title>Admin Login</title>
<link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
<main>
<section class="section">
<div class="glass-panel">
<p class="eyebrow">ADMIN</p>
<h1>Sign in</h1>
<?php if ($error): ?><p role="alert"><?=e($error)?></p><?php endif; ?>
<form method="post" class="contact-form" autocomplete="on">
<input type="hidden" name="_csrf" value="<?=e(csrf_token())?>">
<input type="email" name="email" placeholder="Email" autocomplete="username" maxlength="255" required>
<input type="password" name="password" placeholder="Password" autocomplete="current-password" required>
<button class="button button--primary" type="submit">Sign in</button>
</form>
</div>
</section>
</main>
</body>
</html>
