<?php
// Setup admin hanya boleh dijalankan sekali dan hanya dari komputer lokal.
session_start();
require_once __DIR__ . '/../config/database.php';

$remote = $_SERVER['REMOTE_ADDR'] ?? '';
if (!in_array($remote, ['127.0.0.1', '::1'], true)) {
    http_response_code(403);
    exit('Akses setup admin hanya diizinkan dari komputer lokal.');
}

$lockFile = __DIR__ . '/../config/admin_setup.lock';
if (file_exists($lockFile)) {
    http_response_code(403);
    exit('Setup admin sudah dikunci. Gunakan login admin.');
}

$userCount = (int)$pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
if ($userCount > 0) {
    @file_put_contents($lockFile, 'Admin setup disabled: ' . date('c'));
    http_response_code(403);
    exit('Akun admin sudah ada. Setup baru tidak diizinkan.');
}

if (empty($_SESSION['admin_setup_csrf'])) {
    $_SESSION['admin_setup_csrf'] = bin2hex(random_bytes(32));
}

$error = '';
$success = false;
$usernameValue = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf'] ?? '';
    $usernameValue = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if (!hash_equals($_SESSION['admin_setup_csrf'], $token)) {
        $error = 'Permintaan tidak valid. Muat ulang halaman dan coba lagi.';
    } elseif (!preg_match('/^[A-Za-z0-9_.-]{4,30}$/', $usernameValue)) {
        $error = 'Username harus 4–30 karakter dan hanya boleh berisi huruf, angka, titik, garis bawah, atau tanda minus.';
    } elseif (strlen($password) < 12) {
        $error = 'Password minimal 12 karakter.';
    } elseif ($password !== $confirm) {
        $error = 'Konfirmasi password tidak sama.';
    } else {
        try {
            $pdo->beginTransaction();

            $check = $pdo->prepare('SELECT COUNT(*) FROM users WHERE username = ?');
            $check->execute([$usernameValue]);
            if ((int)$check->fetchColumn() > 0) {
                throw new RuntimeException('Username tersebut sudah digunakan.');
            }

            $hash = password_hash($password, PASSWORD_DEFAULT);
            $insert = $pdo->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
            $insert->execute([$usernameValue, $hash]);

            $pdo->commit();
            @file_put_contents($lockFile, 'Admin setup completed: ' . date('c'));
            unset($_SESSION['admin_setup_csrf']);
            $success = true;
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            $error = $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Setup Admin - Niren</title>
<style>
body{font-family:Arial,sans-serif;background:#f6eedd;display:grid;place-items:center;min-height:100vh;margin:0;color:#2a1b10}
.box{width:min(430px,90%);background:#fff;padding:30px;border-radius:14px;box-shadow:0 10px 30px #0002}
input,button{width:100%;padding:12px;margin-top:8px;box-sizing:border-box;border-radius:8px;border:1px solid #ccc}
button{background:#72b81c;border:0;cursor:pointer;font-weight:bold}
.error{color:#a00020;background:#fff0f0;padding:10px;border-radius:8px}
.success{color:#165c2a;background:#effbf1;padding:12px;border-radius:8px}
small{color:#666}
a{color:#315b19}
</style>
</head>
<body>
<div class="box">
<h2>Buat Admin Niren</h2>
<?php if ($success): ?>
    <div class="success">
        <strong>Admin berhasil dibuat.</strong><br><br>
        Username: <strong><?= htmlspecialchars($usernameValue) ?></strong><br>
        Password tersimpan dalam bentuk hash dan tidak ditampilkan kembali.<br><br>
        Setup otomatis dikunci agar tidak dapat dijalankan lagi.
    </div>
    <p><a href="login.php">Masuk ke Login Admin →</a></p>
<?php else: ?>
    <p>Halaman ini hanya dapat digunakan sekali dari komputer lokal.</p>
    <?php if ($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
    <form method="post" autocomplete="off">
        <input type="hidden" name="csrf" value="<?= htmlspecialchars($_SESSION['admin_setup_csrf']) ?>">
        <label>Username</label>
        <input type="text" name="username" value="<?= htmlspecialchars($usernameValue) ?>" minlength="4" maxlength="30" required>
        <small>4–30 karakter: huruf, angka, titik, _ atau -.</small>

        <label style="display:block;margin-top:15px">Password</label>
        <input type="password" name="password" minlength="12" required autocomplete="new-password">
        <small>Gunakan minimal 12 karakter dan jangan gunakan password yang mudah ditebak.</small>

        <label style="display:block;margin-top:15px">Ulangi Password</label>
        <input type="password" name="confirm_password" minlength="12" required autocomplete="new-password">

        <button type="submit">Buat Admin</button>
    </form>
<?php endif; ?>
</div>
</body>
</html>
