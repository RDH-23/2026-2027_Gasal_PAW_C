<?php
require 'auth.php';
wajib_login();
require 'koneksi.php';

$level = (int)$_SESSION['level'];
$total_barang    = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS jml FROM barang"))['jml'];
$total_supplier  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS jml FROM supplier"))['jml'];
$total_pelanggan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS jml FROM pelanggan"))['jml'];
$total_transaksi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS jml FROM transaksi"))['jml'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Sistem Penjualan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>

<main>
    <?php if (isset($_GET['pesan']) && $_GET['pesan'] === 'ditolak'): ?>
        <div class="alert alert-error">Akses ditolak. Menu Data Master hanya dapat diakses oleh Owner (Level 1).</div>
    <?php endif; ?>

    <h2>Selamat Datang, <?= htmlspecialchars($_SESSION['nama']) ?></h2>
    <p class="periode">
        Status Login: <strong><?= $level === 1 ? 'Owner (Level 1)' : 'Kasir (Level 2)' ?></strong> &mdash;
        Username: <code><?= htmlspecialchars($_SESSION['username']) ?></code>
    </p>

    <div class="ringkasan">
        <div class="card">
            <span class="card-label">Total Data Barang</span>
            <span class="card-nilai"><?= number_format($total_barang, 0, ',', '.') ?> Item</span>
        </div>
        <div class="card">
            <span class="card-label">Total Supplier</span>
            <span class="card-nilai"><?= number_format($total_supplier, 0, ',', '.') ?> Supplier</span>
        </div>
        <div class="card">
            <span class="card-label">Total Pelanggan</span>
            <span class="card-nilai"><?= number_format($total_pelanggan, 0, ',', '.') ?> Orang</span>
        </div>
        <div class="card">
            <span class="card-label">Total Transaksi</span>
            <span class="card-nilai"><?= number_format($total_transaksi, 0, ',', '.') ?> Transaksi</span>
        </div>
    </div>
</main>

<script src="script.js"></script>
</body>
</html>