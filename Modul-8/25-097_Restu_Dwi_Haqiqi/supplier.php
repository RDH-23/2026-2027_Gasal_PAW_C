<?php
require 'auth.php';
wajib_owner();
require 'koneksi.php';

$pesan = "";
$tipe_pesan = "";

if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    try {
        $stmt = mysqli_prepare($conn, "DELETE FROM supplier WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        header("Location: supplier.php?msg=hapus");
        exit;
    } catch (mysqli_sql_exception $e) {
        $pesan = "Supplier tidak dapat dihapus karena masih memiliki data barang terkait.";
        $tipe_pesan = "alert-error";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id     = (int)($_POST['id'] ?? 0);
    $nama   = trim($_POST['nama']);
    $telp   = trim($_POST['telp']);
    $alamat = trim($_POST['alamat']);

    if ($id > 0) {
        $stmt = mysqli_prepare($conn, "UPDATE supplier SET nama=?, telp=?, alamat=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "sssi", $nama, $telp, $alamat, $id);
        mysqli_stmt_execute($stmt);
        header("Location: supplier.php?msg=ubah");
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO supplier (nama, telp, alamat) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $nama, $telp, $alamat);
        mysqli_stmt_execute($stmt);
        header("Location: supplier.php?msg=tambah");
    }
    exit;
}

if (isset($_GET['msg'])) {
    $tipe_pesan = "alert-sukses";
    if ($_GET['msg'] === 'tambah') $pesan = "Data supplier berhasil ditambahkan.";
    if ($_GET['msg'] === 'ubah')   $pesan = "Data supplier berhasil diperbarui.";
    if ($_GET['msg'] === 'hapus')  $pesan = "Data supplier berhasil dihapus.";
}

$edit = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt = mysqli_prepare($conn, "SELECT * FROM supplier WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $edit = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}

$suppliers = mysqli_query($conn, "SELECT * FROM supplier ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Supplier - Sistem Penjualan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>

<main>
    <h2><?= $edit ? 'Edit Data Supplier' : 'Tambah Data Supplier' ?></h2>

    <?php if ($pesan !== ''): ?>
        <div class="alert <?= $tipe_pesan ?>"><?= htmlspecialchars($pesan) ?></div>
    <?php endif; ?>

    <form method="POST" action="supplier.php" class="form-grid">
        <input type="hidden" name="id" value="<?= $edit['id'] ?? 0 ?>">

        <label>Nama Supplier
            <input type="text" name="nama" maxlength="100" required value="<?= htmlspecialchars($edit['nama'] ?? '') ?>">
        </label>
        <label>No. Telepon
            <input type="text" name="telp" maxlength="12" value="<?= htmlspecialchars($edit['telp'] ?? '') ?>">
        </label>
        <label>Alamat
            <input type="text" name="alamat" value="<?= htmlspecialchars($edit['alamat'] ?? '') ?>">
        </label>
        <div class="form-btn-group">
            <button type="submit"><?= $edit ? 'Update' : 'Simpan' ?></button>
            <?php if ($edit): ?>
                <a href="supplier.php" class="btn-batal">Batal</a>
            <?php endif; ?>
        </div>
    </form>

    <hr class="divider">

    <h2>Daftar Data Supplier</h2>
    <table>
        <thead>
            <tr>
                <th style="width: 55px;">No</th>
                <th>Nama Supplier</th>
                <th>Telepon</th>
                <th>Alamat</th>
                <th style="width: 140px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; while ($row = mysqli_fetch_assoc($suppliers)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['telp'] ?? '-') ?></td>
                <td><?= htmlspecialchars($row['alamat'] ?? '-') ?></td>
                <td class="aksi-tabel">
                    <a href="supplier.php?edit=<?= $row['id'] ?>" class="btn-edit">Edit</a>
                    <a href="supplier.php?hapus=<?= $row['id'] ?>" class="btn-hapus" data-confirm="Hapus supplier <?= htmlspecialchars($row['nama']) ?>?">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>

<script src="script.js"></script>
</body>
</html>