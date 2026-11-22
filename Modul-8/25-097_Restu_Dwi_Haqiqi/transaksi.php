<?php
require 'auth.php';
wajib_login();
require 'koneksi.php';

$pesan = "";
$tipe_pesan = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $waktu_transaksi = $_POST['waktu_transaksi'];
    $pelanggan_id    = $_POST['pelanggan_id'];
    $barang_id       = (int)$_POST['barang_id'];
    $qty             = (int)$_POST['qty'];
    $keterangan      = trim($_POST['keterangan']);

    // Ambil harga & stok barang terpilih
    $stmt_brg = mysqli_prepare($conn, "SELECT harga, stok FROM barang WHERE id = ?");
    mysqli_stmt_bind_param($stmt_brg, "i", $barang_id);
    mysqli_stmt_execute($stmt_brg);
    $brg = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt_brg));

    if (!$brg) {
        $pesan = "Barang tidak ditemukan.";
        $tipe_pesan = "alert-error";
    } elseif ($qty < 1 || $qty > (int)$brg['stok']) {
        $pesan = "Jumlah (qty) melebihi stok tersedia (" . $brg['stok'] . ").";
        $tipe_pesan = "alert-error";
    } else {
        $harga = (int)$brg['harga'];
        $total = $harga * $qty;

        mysqli_begin_transaction($conn);
        try {
            // Simpan header transaksi
            $stmt1 = mysqli_prepare($conn, "INSERT INTO transaksi (waktu_transaksi, keterangan, total, pelanggan_id) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt1, "ssis", $waktu_transaksi, $keterangan, $total, $pelanggan_id);
            mysqli_stmt_execute($stmt1);
            $transaksi_id = mysqli_insert_id($conn);

            // Simpan detail transaksi
            $stmt2 = mysqli_prepare($conn, "INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt2, "iiii", $transaksi_id, $barang_id, $harga, $qty);
            mysqli_stmt_execute($stmt2);

            // Kurangi stok barang
            $stmt3 = mysqli_prepare($conn, "UPDATE barang SET stok = stok - ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt3, "ii", $qty, $barang_id);
            mysqli_stmt_execute($stmt3);

            mysqli_commit($conn);
            header("Location: transaksi.php?msg=sukses");
            exit;
        } catch (Exception $e) {
            mysqli_rollback($conn);
            $pesan = "Gagal menyimpan transaksi: " . $e->getMessage();
            $tipe_pesan = "alert-error";
        }
    }
}

if (isset($_GET['msg']) && $_GET['msg'] === 'sukses') {
    $pesan = "Transaksi penjualan berhasil disimpan.";
    $tipe_pesan = "alert-sukses";
}

$pelanggans = mysqli_query($conn, "SELECT id, nama FROM pelanggan ORDER BY nama ASC");
$barangs    = mysqli_query($conn, "SELECT id, kode_barang, nama_barang, harga, stok FROM barang WHERE stok > 0 ORDER BY nama_barang ASC");

$transaksis = mysqli_query($conn, "
    SELECT t.id, t.waktu_transaksi, t.keterangan, t.total, p.nama AS nama_pelanggan,
           GROUP_CONCAT(CONCAT(b.nama_barang, ' (', td.qty, 'x)') SEPARATOR ', ') AS rincian_barang
    FROM transaksi t
    JOIN pelanggan p ON t.pelanggan_id = p.id
    LEFT JOIN transaksi_detail td ON t.id = td.transaksi_id
    LEFT JOIN barang b ON td.barang_id = b.id
    GROUP BY t.id
    ORDER BY t.id DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi - Sistem Penjualan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>

<main>
    <h2>Input Transaksi Penjualan</h2>

    <?php if ($pesan !== ''): ?>
        <div class="alert <?= $tipe_pesan ?>"><?= htmlspecialchars($pesan) ?></div>
    <?php endif; ?>

    <form method="POST" action="transaksi.php" class="form-grid" id="formTransaksi">
        <label>Tanggal Transaksi
            <input type="date" name="waktu_transaksi" required value="<?= date('Y-m-d') ?>">
        </label>
        <label>Pelanggan
            <select name="pelanggan_id" required>
                <option value="">-- Pilih Pelanggan --</option>
                <?php while ($p = mysqli_fetch_assoc($pelanggans)): ?>
                    <option value="<?= htmlspecialchars($p['id']) ?>">
                        <?= htmlspecialchars($p['id'] . ' - ' . $p['nama']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </label>
        <label>Barang
            <select name="barang_id" id="selectBarang" required>
                <option value="" data-harga="0">-- Pilih Barang --</option>
                <?php while ($b = mysqli_fetch_assoc($barangs)): ?>
                    <option value="<?= $b['id'] ?>" data-harga="<?= $b['harga'] ?>">
                        <?= htmlspecialchars($b['nama_barang']) ?> (Rp <?= number_format($b['harga'], 0, ',', '.') ?> | Stok: <?= $b['stok'] ?>)
                    </option>
                <?php endwhile; ?>
            </select>
        </label>
        <label>Qty
            <input type="number" name="qty" id="inputQty" min="1" value="1" required>
        </label>
        <label>Estimasi Total
            <input type="text" id="estimasiTotal" readonly value="Rp 0">
        </label>
        <label>Keterangan
            <input type="text" name="keterangan" required placeholder="Catatan transaksi">
        </label>
        <div class="form-btn-group">
            <button type="submit">Simpan Transaksi</button>
        </div>
    </form>

    <hr class="divider">

    <h2>Daftar Riwayat Transaksi</h2>
    <table>
        <thead>
            <tr>
                <th style="width: 55px;">No</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Item Barang</th>
                <th>Keterangan</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; while ($row = mysqli_fetch_assoc($transaksis)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['waktu_transaksi']) ?></td>
                <td><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
                <td><?= htmlspecialchars($row['rincian_barang'] ?? '-') ?></td>
                <td><?= htmlspecialchars($row['keterangan'] ?? '-') ?></td>
                <td>Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>

<script src="script.js"></script>
</body>
</html>