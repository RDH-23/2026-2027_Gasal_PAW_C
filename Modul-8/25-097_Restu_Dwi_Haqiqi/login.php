<?php
session_start();
require 'koneksi.php';

// Jika sudah login, tidak boleh mengakses halaman login
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    header("Location: index.php");
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $error = "Username dan password tidak boleh kosong.";
    } else {
        $stmt = mysqli_prepare($conn, "SELECT id_user, username, password, nama, level FROM user WHERE username = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        if ($user && md5($password) === $user['password']) {
            $lvl = (int)$user['level'];
            if ($lvl === 1 || $lvl === 2) {
                session_regenerate_id(true);
                $_SESSION['login']    = true;
                $_SESSION['id_user']  = (int)$user['id_user'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['nama']     = $user['nama'];
                $_SESSION['level']    = $lvl;

                header("Location: index.php");
                exit;
            } else {
                $error = "Level user ini tidak memiliki hak akses login ke Sistem Penjualan.";
            }
        } else {
            $error = "Username atau password salah.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Penjualan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-wrapper">
    <div class="login-box">
        <h2>Login Sistem Penjualan</h2>
        <p class="login-sub">Masukkan username dan password Anda</p>

        <?php if ($error !== ''): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (isset($_GET['status']) && $_GET['status'] === 'logout'): ?>
            <div class="alert alert-sukses">Anda telah berhasil logout.</div>
        <?php endif; ?>

        <form method="POST" action="login.php" class="form-vertical">
            <label>Username
                <input type="text" name="username" required autofocus placeholder="Contoh: admin atau kasir1">
            </label>
            <label>Password
                <input type="password" name="password" required placeholder="Masukkan password">
            </label>
            <button type="submit" class="btn-full">Login</button>
        </form>
    </div>
</body>
</html>