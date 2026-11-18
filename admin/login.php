<?php
require_once dirname(__DIR__) . '/includes/bootstrap.php';
if (!empty($_SESSION['admin_id'])) { header('Location: dashboard.php'); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $email = trim((string)($_POST['email'] ?? '')); $ip = substr((string)($_SERVER['REMOTE_ADDR'] ?? ''), 0, 45);
    $limit = db()->prepare('SELECT COUNT(*) FROM login_attempts WHERE ip_address=? AND attempted_at > NOW() - INTERVAL 15 MINUTE'); $limit->execute([$ip]);
    if ((int)$limit->fetchColumn() >= 5) { $error = 'Too many attempts. Please wait 15 minutes and try again.'; }
    else {
        $q = db()->prepare('SELECT id,email,password_hash FROM admins WHERE email=?'); $q->execute([$email]); $admin = $q->fetch();
        if ($admin && password_verify((string)($_POST['password'] ?? ''), $admin['password_hash'])) {
            db()->prepare('DELETE FROM login_attempts WHERE ip_address=?')->execute([$ip]);
            session_regenerate_id(true); $_SESSION['admin_id'] = (int)$admin['id']; $_SESSION['admin_email'] = $admin['email'];
            header('Location: dashboard.php'); exit;
        }
        db()->prepare('INSERT INTO login_attempts (ip_address,attempted_at) VALUES (?,NOW())')->execute([$ip]);
        $error = 'Email or password is incorrect.';
    }
}
?><!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin Login</title><link rel="stylesheet" href="../css/style.css"></head><body><main class="section container" style="max-width:520px"><h1>Administrator login</h1><?php if($error): ?><p role="alert"><?=e($error)?></p><?php endif ?><div class="card"><form method="post"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>"><div class="form-group"><label for="email">Email</label><input id="email" type="email" name="email" required autocomplete="username"></div><div class="form-group"><label for="password">Password</label><input id="password" type="password" name="password" required autocomplete="current-password"></div><button class="btn btn-primary">Sign in</button></form></div><p><a href="../index.php">Back to portfolio</a></p></main></body></html>
