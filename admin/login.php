<?php
declare(strict_types=1);
require_once __DIR__.'/../config/bootstrap.php';

$error=null;
if($_SERVER['REQUEST_METHOD']==='POST'){
    if(!verify_csrf($_POST['_csrf']??null)){
        $error='Invalid security token.';
    }else{
        $email=strtolower(trim((string)($_POST['email']??'')));
        $password=(string)($_POST['password']??'');
        $ip=$_SERVER['REMOTE_ADDR']??'';
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)||strlen($email)>255||strlen($password)>1024||filter_var($ip,FILTER_VALIDATE_IP)===false){
            $error='Invalid credentials.';
        }else{
            try{
                $rate=db()->prepare("SELECT COUNT(*) FROM admin_login_attempts WHERE attempted_at >= NOW() - INTERVAL '15 minutes' AND succeeded=FALSE AND (ip_address=:ip OR email=:email)");
                $rate->execute([':ip'=>$ip,':email'=>$email]);
                if((int)$rate->fetchColumn()>=5){
                    $error='Too many failed attempts. Please try again later.';
                }else{
                    $s=db()->prepare('SELECT * FROM admins WHERE email=:email LIMIT 1');
                    $s->execute([':email'=>$email]);
                    $admin=$s->fetch();
                    $valid=$admin&&password_verify($password,$admin['password_hash']);
                    $audit=db()->prepare('INSERT INTO admin_login_attempts(ip_address,email,succeeded) VALUES(:ip,:email,:succeeded)');
                    $audit->execute([':ip'=>$ip,':email'=>$email,':succeeded'=>$valid]);
                    if($valid){
                        session_regenerate_id(true);
                        $_SESSION['admin_id']=$admin['id'];
                        header('Location:/admin/');
                        exit;
                    }
                    $error='Invalid credentials.';
                }
            }catch(Throwable $e){
                error_log('[admin-login] authentication service failed: '.get_class($e));
                $error='The authentication service is temporarily unavailable.';
            }
        }
    }
}
?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin Login</title><link rel="stylesheet" href="/assets/css/app.css"></head><body><main><section class="section"><div class="glass-panel"><p class="eyebrow">ADMIN</p><h1>Sign in</h1><?php if($error): ?><p><?=e($error)?></p><?php endif; ?><form method="post" class="contact-form"><input type="hidden" name="_csrf" value="<?=e(csrf_token())?>"><input type="email" name="email" maxlength="255" autocomplete="username" placeholder="Email" required><input type="password" name="password" maxlength="1024" autocomplete="current-password" placeholder="Password" required><button class="button button--primary" type="submit">Sign in</button></form></div></section></main></body></html>
