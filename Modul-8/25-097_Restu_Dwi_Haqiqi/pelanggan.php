<?php
require 'auth.php';
wajib_owner();
require 'koneksi.php';

$pesan = "";
$tipe_pesan = "";

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    try {
        $stmt = mysqli_prepare($conn, "DELETE FROM pelanggan WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        header("Location: pelanggan.php?msg=hapus");
        exit;
    } catch (mysqli_sql_exception $e) {
        $pesan = "Pelanggan tidak dapat dihapus karena masih memiliki riwayat transaksi.";
        $tipe_pesan = "alert-error";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mode          = $_POST['mode'] ?? 'tambah';
    $id            = trim($_POST['id']);
    $nama          = trim($_POST['nama']);
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $telp          = trim($_POST['telp']);
    $alamat        = trim($_POST['alamat']);

    if ($mode === 'edit') {
        $stmt = mysqli_prepare($conn, "UPDATE pelanggan SET nama=?, jenis_kelamin=?, telp=?, alamat=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "sssss", $nama, $jenis_kelamin, $telp, $alamat, $id);
        mysqli_stmt_execute($stmt);
        header("Location: pelanggan.php?msg=ubah");
        exit;
    } else {
        try {
            $stmt = mysqli_prepare($conn, "INSERT INTO pelanggan (id, nama, jenis_kelamin, telp, alamat) VALUES (?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sssss", $id, $nama, $jenis_kelamin, $telp, $alamat);
            mysqli_stmt_execute($stmt);
            header("Location: pelanggan.php?msg=tambah");
            exit;
        } catch (mysqli_sql_exception $e) {
            $pesan = "ID Pelanggan '$id' sudah terdaftar. Gunakan ID lain.";
            $tipe_pesan = "alert-error";
        }
    }
}

if (isset($_GET['msg'])) {
    $tipe_pesan = "alert-sukses";
    if ($_GET['msg'] === 'tambah') $pesan = "Data pelanggan berhasil ditambahkan.";
    if ($_GET['msg'] === 'ubah')   $pesan = "Data pelanggan berhasil diperbarui.";
    if ($_GET['msg'] === 'hapus')  $pesan = "Data pelanggan berhasil dihapus.";
}

$edit = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = mysqli_prepare($conn, "SELECT * FROM pelanggan WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $edit = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}

// Generate rekomendasi ID berikutnya (misal PLG011)
$last_row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM pelanggan ORDER BY id DESC LIMIT 1"));
$next_num = $last_row ? ((int)preg_replace('/\D/', '', $last_row['id']) + 1) : 1;
$rekomendasi_id = 'PLG' . str_pad((string)$next_num, 3, '0', STR_PAD_LEFT);

$pelanggans = mysqli_query($conn, "SELECT * FROM pelanggan ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pelanggan - Sistem Penjualan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>

<main>
    <h2><?= $edit ? 'Edit Data Pelanggan' : 'Tambah Data Pelanggan' ?></h2>

    <?php if ($pesan !== ''): ?>
        <div class="alert <?= $tipe_pesan ?>"><?= htmlspecialchars($pesan) ?></div>
    <?php endif; ?>

    <form method="POST" action="pelanggan.php" class="form-grid">
        <input type="hidden" name="mode" value="<?= $edit ? 'edit' : 'tambah' ?>">

        <label>ID Pelanggan
            <input type="text" name="id" maxlength="20" required
                   value="<?= htmlspecialchars($edit['id'] ?? $rekomendasi_id) ?>"
                   <?= $edit ? 'readonly' : '' ?>>
        </label>
        <label>Nama Pelanggan
            <input type="text" name="nama" maxlength="100" required value="<?= htmlspecialchars($edit['nama'] ?? '') ?>">
        </label>
        <label>Jenis Kelamin
            <select name="jenis_kelamin" required>
                <option value="L" <?= ($edit['jenis_kelamin'] ?? '') === 'L' ? 'selected' : '' ?>>Laki-laki</option>
                <option value="P" <?= ($edit['jenis_kelamin'] ?? '') === 'P' ? 'selected' : '' ?>>Perempuan</option>
            </select>
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
                <a href="pelanggan.php" class="btn-batal">Batal</a>
            <?php endif; ?>
        </div>
    </form>

    <hr class="divider">

    <h2>Daftar Data Pelanggan</h2>
    <table>
        <thead>
            <tr>
                <th style="width: 55px;">No</th>
                <th>ID</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Telepon</th>
                <th>Alamat</th>
                <th style="width: 140px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; while ($row = mysqli_fetch_assoc($pelanggans)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= $row['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                <td><?= htmlspecialchars($row['telp'] ?? '-') ?></td>
                <td><?= htmlspecialchars($row['alamat'] ?? '-') ?></td>
                <td class="aksi-tabel">
                    <a href="pelanggan.php?edit=<?= urlencode($row['id']) ?>" class="btn-edit">Edit</a>
                    <a href="pelanggan.php?hapus=<?= urlencode($row['id']) ?>" class="btn-hapus" data-confirm="Hapus pelanggan <?= htmlspecialchars($row['nama']) ?>?">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>

<script src="script.js"></script>
</body>
</html>