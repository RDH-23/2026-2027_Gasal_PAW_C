<?php
require 'auth.php';
wajib_owner();
require 'koneksi.php';

$pesan = "";
$tipe_pesan = "";

// Hapus Barang
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    try {
        $stmt = mysqli_prepare($conn, "DELETE FROM barang WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        header("Location: barang.php?msg=hapus");
        exit;
    } catch (mysqli_sql_exception $e) {
        $pesan = "Barang tidak dapat dihapus karena sudah tercatat pada detail transaksi.";
        $tipe_pesan = "alert-error";
    }
}

// Tambah / Edit Barang
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id          = (int)($_POST['id'] ?? 0);
    $kode_barang = trim($_POST['kode_barang']);
    $nama_barang = trim($_POST['nama_barang']);
    $harga       = (int)$_POST['harga'];
    $stok        = (int)$_POST['stok'];
    $supplier_id = (int)$_POST['supplier_id'];

    if ($id > 0) {
        $stmt = mysqli_prepare($conn, "UPDATE barang SET kode_barang=?, nama_barang=?, harga=?, stok=?, supplier_id=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "ssiiii", $kode_barang, $nama_barang, $harga, $stok, $supplier_id, $id);
        mysqli_stmt_execute($stmt);
        header("Location: barang.php?msg=ubah");
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO barang (kode_barang, nama_barang, harga, stok, supplier_id) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssiii", $kode_barang, $nama_barang, $harga, $stok, $supplier_id);
        mysqli_stmt_execute($stmt);
        header("Location: barang.php?msg=tambah");
    }
    exit;
}

if (isset($_GET['msg'])) {
    $tipe_pesan = "alert-sukses";
    if ($_GET['msg'] === 'tambah') $pesan = "Data barang berhasil ditambahkan.";
    if ($_GET['msg'] === 'ubah')   $pesan = "Data barang berhasil diperbarui.";
    if ($_GET['msg'] === 'hapus')  $pesan = "Data barang berhasil dihapus.";
}

$edit = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt = mysqli_prepare($conn, "SELECT * FROM barang WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $edit = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}

$suppliers = mysqli_query($conn, "SELECT id, nama FROM supplier ORDER BY nama ASC");
$barangs   = mysqli_query($conn, "
    SELECT b.*, s.nama AS nama_supplier
    FROM barang b
    JOIN supplier s ON b.supplier_id = s.id
    ORDER BY b.id ASC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang - Sistem Penjualan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>

<main>
    <h2><?= $edit ? 'Edit Data Barang' : 'Tambah Data Barang' ?></h2>

    <?php if ($pesan !== ''): ?>
        <div class="alert <?= $tipe_pesan ?>"><?= htmlspecialchars($pesan) ?></div>
    <?php endif; ?>

    <form method="POST" action="barang.php" class="form-grid">
        <input type="hidden" name="id" value="<?= $edit['id'] ?? 0 ?>">

        <label>Kode Barang
            <input type="text" name="kode_barang" maxlength="10" required value="<?= htmlspecialchars($edit['kode_barang'] ?? '') ?>" placeholder="BRG011">
        </label>
        <label>Nama Barang
            <input type="text" name="nama_barang" maxlength="100" required value="<?= htmlspecialchars($edit['nama_barang'] ?? '') ?>">
        </label>
        <label>Harga (Rp)
            <input type="number" name="harga" min="0" required value="<?= $edit['harga'] ?? '' ?>">
        </label>
        <label>Stok
            <input type="number" name="stok" min="0" required value="<?= $edit['stok'] ?? '' ?>">
        </label>
        <label>Supplier
            <select name="supplier_id" required>
                <option value="">-- Pilih Supplier --</option>
                <?php while ($s = mysqli_fetch_assoc($suppliers)): ?>
                    <option value="<?= $s['id'] ?>" <?= ($edit['supplier_id'] ?? '') == $s['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($s['nama']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </label>
        <div class="form-btn-group">
            <button type="submit"><?= $edit ? 'Update' : 'Simpan' ?></button>
            <?php if ($edit): ?>
                <a href="barang.php" class="btn-batal">Batal</a>
            <?php endif; ?>
        </div>
    </form>

    <hr class="divider">

    <h2>Daftar Data Barang</h2>
    <table>
        <thead>
            <tr>
                <th style="width: 55px;">No</th>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Supplier</th>
                <th style="width: 140px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; while ($row = mysqli_fetch_assoc($barangs)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['kode_barang']) ?></td>
                <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                <td><?= $row['stok'] ?></td>
                <td><?= htmlspecialchars($row['nama_supplier']) ?></td>
                <td class="aksi-tabel">
                    <a href="barang.php?edit=<?= $row['id'] ?>" class="btn-edit">Edit</a>
                    <a href="barang.php?hapus=<?= $row['id'] ?>" class="btn-hapus" data-confirm="Hapus barang <?= htmlspecialchars($row['nama_barang']) ?>?">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>

<script src="script.js"></script>
</body>
</html>