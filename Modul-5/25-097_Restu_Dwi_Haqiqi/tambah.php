<?php
include 'koneksi.php';
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama']; $telp = $_POST['telp']; $alamat = $_POST['alamat'];
    mysqli_query($koneksi, "INSERT INTO supplier (nama, telp, alamat) VALUES ('$nama', '$telp', '$alamat')");
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tambah Data Master Supplier Baru</title>
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
            <tr><td>Nama</td><td><input type="text" name="nama" placeholder="Nama" required></td></tr>
            <tr><td>Telp</td><td><input type="text" name="telp" placeholder="telp" maxlength="12" required></td></tr>
            <tr><td>Alamat</td><td><input type="text" name="alamat" placeholder="alamat" required></td></tr>
            <tr>
                <td></td>
                <td>
                    <button type="submit" name="simpan" class="btn btn-green">Simpan</button>
                    <a href="index.php" class="btn btn-red">Batal</a>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>