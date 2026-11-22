<?php
require 'auth.php';
wajib_owner();
require 'koneksi.php';

$pesan = "";
$tipe_pesan = "";

if (isset($_GET['hapus'])) {
    $id_user = (int)$_GET['hapus'];
    if ($id_user === (int)$_SESSION['id_user']) {
        $pesan = "Akun yang sedang digunakan login tidak dapat dihapus.";
        $tipe_pesan = "alert-error";
    } else {
        $stmt = mysqli_prepare($conn, "DELETE FROM user WHERE id_user = ?");
        mysqli_stmt_bind_param($stmt, "i", $id_user);
        mysqli_stmt_execute($stmt);
        header("Location: user.php?msg=hapus");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user  = (int)($_POST['id_user'] ?? 0);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $nama     = trim($_POST['nama']);
    $alamat   = trim($_POST['alamat']);
    $hp       = trim($_POST['hp']);
    $level    = (int)$_POST['level'];

    if ($id_user > 0) {
        if ($password !== '') {
            $pass_md5 = md5($password);
            $stmt = mysqli_prepare($conn, "UPDATE user SET username=?, password=?, nama=?, alamat=?, hp=?, level=? WHERE id_user=?");
            mysqli_stmt_bind_param($stmt, "sssssii", $username, $pass_md5, $nama, $alamat, $hp, $level, $id_user);
        } else {
            $stmt = mysqli_prepare($conn, "UPDATE user SET username=?, nama=?, alamat=?, hp=?, level=? WHERE id_user=?");
            mysqli_stmt_bind_param($stmt, "ssssii", $username, $nama, $alamat, $hp, $level, $id_user);
        }
        mysqli_stmt_execute($stmt);
        header("Location: user.php?msg=ubah");
    } else {
        $pass_md5 = md5($password);
        $stmt = mysqli_prepare($conn, "INSERT INTO user (username, password, nama, alamat, hp, level) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssssi", $username, $pass_md5, $nama, $alamat, $hp, $level);
        mysqli_stmt_execute($stmt);
        header("Location: user.php?msg=tambah");
    }
    exit;
}

if (isset($_GET['msg'])) {
    $tipe_pesan = "alert-sukses";
    if ($_GET['msg'] === 'tambah') $pesan = "Data user berhasil ditambahkan.";
    if ($_GET['msg'] === 'ubah')   $pesan = "Data user berhasil diperbarui.";
    if ($_GET['msg'] === 'hapus')  $pesan = "Data user berhasil dihapus.";
}

$edit = null;
if (isset($_GET['edit'])) {
    $id_user = (int)$_GET['edit'];
    $stmt = mysqli_prepare($conn, "SELECT * FROM user WHERE id_user = ?");
    mysqli_stmt_bind_param($stmt, "i", $id_user);
    mysqli_stmt_execute($stmt);
    $edit = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}

$users = mysqli_query($conn, "SELECT * FROM user ORDER BY id_user ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data User - Sistem Penjualan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>

<main>
    <h2><?= $edit ? 'Edit Data User' : 'Tambah Data User' ?></h2>

    <?php if ($pesan !== ''): ?>
        <div class="alert <?= $tipe_pesan ?>"><?= htmlspecialchars($pesan) ?></div>
    <?php endif; ?>

    <form method="POST" action="user.php" class="form-grid">
        <input type="hidden" name="id_user" value="<?= $edit['id_user'] ?? 0 ?>">

        <label>Username
            <input type="text" name="username" maxlength="30" required value="<?= htmlspecialchars($edit['username'] ?? '') ?>">
        </label>
        <label>Password <?= $edit ? '(Kosongkan jika tetap)' : '' ?>
            <input type="password" name="password" <?= $edit ? '' : 'required' ?>>
        </label>
        <label>Nama Lengkap
            <input type="text" name="nama" maxlength="50" required value="<?= htmlspecialchars($edit['nama'] ?? '') ?>">
        </label>
        <label>Alamat
            <input type="text" name="alamat" maxlength="150" value="<?= htmlspecialchars($edit['alamat'] ?? '') ?>">
        </label>
        <label>No. HP
            <input type="text" name="hp" maxlength="20" value="<?= htmlspecialchars($edit['hp'] ?? '') ?>">
        </label>
        <label>Level
            <select name="level" required>
                <option value="1" <?= ($edit['level'] ?? 1) == 1 ? 'selected' : '' ?>>1 - Owner</option>
                <option value="2" <?= ($edit['level'] ?? 1) == 2 ? 'selected' : '' ?>>2 - Kasir</option>
            </select>
        </label>
        <div class="form-btn-group">
            <button type="submit"><?= $edit ? 'Update' : 'Simpan' ?></button>
            <?php if ($edit): ?>
                <a href="user.php" class="btn-batal">Batal</a>
            <?php endif; ?>
        </div>
    </form>

    <hr class="divider">

    <h2>Daftar Data User</h2>
    <table>
        <thead>
            <tr>
                <th style="width: 55px;">No</th>
                <th>Username</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>HP</th>
                <th>Level</th>
                <th style="width: 140px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; while ($row = mysqli_fetch_assoc($users)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['alamat'] ?? '-') ?></td>
                <td><?= htmlspecialchars($row['hp'] ?? '-') ?></td>
                <td><?= (int)$row['level'] === 1 ? '1 (Owner)' : '2 (Kasir)' ?></td>
                <td class="aksi-tabel">
                    <a href="user.php?edit=<?= $row['id_user'] ?>" class="btn-edit">Edit</a>
                    <?php if ((int)$row['id_user'] !== (int)$_SESSION['id_user']): ?>
                        <a href="user.php?hapus=<?= $row['id_user'] ?>" class="btn-hapus" data-confirm="Hapus user <?= htmlspecialchars($row['username']) ?>?">Hapus</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>

<script src="script.js"></script>
</body>
</html>