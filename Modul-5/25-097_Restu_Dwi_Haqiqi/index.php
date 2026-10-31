<?php
include 'koneksi.php';
$result = mysqli_query($koneksi, "SELECT * FROM supplier ORDER BY id ASC");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Master Supplier</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        .head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
        h2 { color: #2e7d7a; margin: 0; font-size: 24px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #d6eef8; color: #333; text-align: left; padding: 10px; font-weight: normal; }
        td { padding: 10px; border-bottom: 1px solid #eee; font-size: 14px; }
        .btn { padding: 6px 14px; border-radius: 4px; text-decoration: none; color: #fff; font-size: 13px; font-weight: bold; border: none; cursor: pointer; display: inline-block; }
        .btn-green { background: #7cb342; }
        .btn-orange { background: #e65100; }
        .btn-red { background: #b71c1c; }
    </style>
</head>
<body>
    <div class="head">
        <h2>Data Master Supplier</h2>
        <a href="tambah.php" class="btn btn-green">Tambah Data</a>
    </div>

    <table>
        <tr>
            <th width="5%">No</th>
            <th width="35%">Nama</th>
            <th width="20%">Telp</th>
            <th width="25%">Alamat</th>
            <th width="15%">Tindakan</th>
        </tr>
        <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($row['nama']); ?></td>
            <td><?= htmlspecialchars($row['telp']); ?></td>
            <td><?= htmlspecialchars($row['alamat']); ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-orange">Edit</a>
                <a href="hapus.php?id=<?= $row['id']; ?>" class="btn btn-red" onclick="return confirm('Anda yakin akan menghapus supplier ini?');">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>