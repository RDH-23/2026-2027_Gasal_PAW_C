<?php
require_once 'koneksi.php';

$pesan = '';
$tipe_pesan = '';

if (isset($_GET['aksi']) && $_GET['aksi'] === 'hapus' && isset($_GET['id'])) {
    $id_barang = (int)$_GET['id'];

    $stmt_check = mysqli_prepare($koneksi, "SELECT COUNT(*) as total FROM transaksi_detail WHERE barang_id = ?");
    mysqli_stmt_bind_param($stmt_check, "i", $id_barang);
    mysqli_stmt_execute($stmt_check);
    $check_result = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt_check));

    if ($check_result['total'] > 0) {
        $pesan = "Gagal menghapus: Barang tidak boleh dihapus karena masih digunakan pada " . $check_result['total'] . " data transaksi!";
        $tipe_pesan = "error";
    } else {
        $stmt_del = mysqli_prepare($koneksi, "DELETE FROM barang WHERE id = ?");
        mysqli_stmt_bind_param($stmt_del, "i", $id_barang);
        if (mysqli_stmt_execute($stmt_del)) {
            $pesan = "Data barang berhasil dihapus.";
            $tipe_pesan = "success";
        } else {
            $pesan = "Terjadi kesalahan saat menghapus data: " . mysqli_error($koneksi);
            $tipe_pesan = "error";
        }
    }
}

$query_barang = "SELECT b.*, s.nama AS nama_supplier 
                 FROM barang b 
                 JOIN supplier s ON b.supplier_id = s.id 
                 ORDER BY b.id ASC";
$result_barang = mysqli_query($koneksi, $query_barang);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Data Barang</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 25px; line-height: 1.5; }
        table { border-collapse: collapse; width: 100%; margin-top: 15px; }
        th, td { border: 1px solid #bbb; padding: 8px 12px; }
        th { background: #f2f2f2; }
        .alert { padding: 10px; margin-bottom: 15px; border-radius: 4px; }
        .alert-error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .btn-del { color: #d9534f; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>

    <p><a href="transaksi_detail.php">&laquo; Kembali ke Form Master-Detail Transaksi</a></p>
    <h2>Daftar Data Barang</h2>

    <?php if (!empty($pesan)): ?>
        <div class="alert alert-<?= $tipe_pesan ?>">
            <?= htmlspecialchars($pesan) ?>
        </div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Supplier</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result_barang)): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['kode_barang']) ?></td>
                    <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                    <td><?= htmlspecialchars($row['nama_supplier']) ?></td>
                    <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                    <td><?= $row['stok'] ?></td>
                    <td>
                        <a href="barang.php?aksi=hapus&id=<?= $row['id'] ?>" 
                           class="btn-del" 
                           onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">
                           Hapus
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</body>
</html>