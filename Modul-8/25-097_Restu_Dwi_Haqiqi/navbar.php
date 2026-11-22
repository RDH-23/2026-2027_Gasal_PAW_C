<?php
$level = (int)($_SESSION['level'] ?? 0);
$nama_user = htmlspecialchars($_SESSION['nama'] ?? 'User');
$halaman = basename($_SERVER['PHP_SELF']);
$master_pages = ['barang.php', 'supplier.php', 'pelanggan.php', 'user.php'];
?>
<nav class="navbar no-print">
    <div class="nav-inner">
        <a href="index.php" class="nav-brand">Sistem Penjualan</a>

        <ul class="nav-links">
            <li>
                <a href="index.php" class="<?= $halaman === 'index.php' ? 'active' : '' ?>">Home</a>
            </li>

            <?php if ($level === 1): ?>
                <li class="dropdown">
                    <button type="button" class="dropdown-btn <?= in_array($halaman, $master_pages, true) ? 'active' : '' ?>">
                        Data Master &#9662;
                    </button>
                    <ul class="dropdown-content">
                        <li><a href="barang.php" class="<?= $halaman === 'barang.php' ? 'active' : '' ?>">Data Barang</a></li>
                        <li><a href="supplier.php" class="<?= $halaman === 'supplier.php' ? 'active' : '' ?>">Data Supplier</a></li>
                        <li><a href="pelanggan.php" class="<?= $halaman === 'pelanggan.php' ? 'active' : '' ?>">Data Pelanggan</a></li>
                        <li><a href="user.php" class="<?= $halaman === 'user.php' ? 'active' : '' ?>">Data User</a></li>
                    </ul>
                </li>
            <?php endif; ?>

            <li>
                <a href="transaksi.php" class="<?= $halaman === 'transaksi.php' ? 'active' : '' ?>">Transaksi</a>
            </li>
            <li>
                <a href="laporan.php" class="<?= $halaman === 'laporan.php' ? 'active' : '' ?>">Laporan</a>
            </li>
        </ul>

        <div class="nav-user">
            <span class="user-info"><?= $nama_user ?> (<?= $level === 1 ? 'Owner' : 'Kasir' ?>)</span>
            <a href="logout.php" class="btn-logout" data-confirm="Apakah Anda yakin ingin logout?">Logout</a>
        </div>
    </div>
</nav>