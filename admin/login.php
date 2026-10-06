<?php
session_start();
require_once __DIR__ . '/../config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_username'] = $user['username'];
        header("Location: dashboard.php");
        exit;
    }

    $error = 'Username atau password salah.';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login Admin - Niren</title>
<style>
body{font-family:Arial,sans-serif;background:#f6eedd;display:grid;place-items:center;min-height:100vh;margin:0}
.box{width:min(380px,90%);background:#fff;padding:30px;border-radius:12px;box-shadow:0 10px 30px #0002}
input,button{width:100%;padding:12px;margin-top:8px;box-sizing:border-box}
button{background:#72b81c;border:0;cursor:pointer;font-weight:bold}
.error{color:#b00020}
</style>
</head>
<body>
<div class="box">
<h2>Login Admin Niren</h2>
<?php if ($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
<form method="post">
<label>Username</label>
<input type="text" name="username" required>
<label>Password</label>
<input type="password" name="password" required>
<button type="submit">Login</button>
</form>
</div>
</body>
</html>
