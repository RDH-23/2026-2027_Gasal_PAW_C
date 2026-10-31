<?php
include 'koneksi.php';
$id = intval($_GET['id'] ?? 0);

if (isset($_POST['update'])) {
    $nama = $_POST['nama']; $telp = $_POST['telp']; $alamat = $_POST['alamat'];
    mysqli_query($koneksi, "UPDATE supplier SET nama='$nama', telp='$telp', alamat='$alamat' WHERE id=$id");
    header("Location: index.php");
    exit();
}

$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM supplier WHERE id=$id"));
if (!$data) { header("Location: index.php"); exit(); }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit Data Master Supplier</title>
    <style>
        body { font-family: sans-serif; margin: 30px; }
        table { border: none; }
        td { padding: 8px; border: none; font-size: 14px; font-weight: bold; }
        input { width: 350px; padding: 8px; border: 1px solid #ccc; border-radius: 4px; outline: none; }
        .btn { padding: 8px 16px; border-radius: 4px; text-decoration: none; color: #fff; font-size: 13px; font-weight: bold; border: none; cursor: pointer; }
        .btn-green { background: #7cb342; }
        .btn-red { background: #b71c1c; }
    </style>
</head>
<body>
    <form method="post">
        <table>
            <tr><td>Nama</td><td><input type="text" name="nama" value="<?= htmlspecialchars($data['nama']); ?>" required></td></tr>
            <tr><td>Telp</td><td><input type="text" name="telp" value="<?= htmlspecialchars($data['telp']); ?>" maxlength="12" required></td></tr>
            <tr><td>Alamat</td><td><input type="text" name="alamat" value="<?= htmlspecialchars($data['alamat']); ?>" required></td></tr>
            <tr>
                <td></td>
                <td>
                    <button type="submit" name="update" class="btn btn-green">Update</button>
                    <a href="index.php" class="btn btn-red">Batal</a>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>