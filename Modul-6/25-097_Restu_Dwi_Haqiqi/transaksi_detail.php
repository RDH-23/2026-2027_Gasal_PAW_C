<?php
require_once 'koneksi.php';

$transaksi_id = isset($_GET['id']) ? (int)$_GET['id'] : 1;
$pesan = '';

// Handle Submit Tambah Item Detail (Poin 4: Otomatis Update Total)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah_detail'])) {
    $barang_id = (int)$_POST['barang_id'];
    $qty       = (int)$_POST['qty'];

    if ($barang_id > 0 && $qty > 0) {
        // Ambil harga terkini dari tabel barang
        $stmt_brg = mysqli_prepare($koneksi, "SELECT harga FROM barang WHERE id = ?");
        mysqli_stmt_bind_param($stmt_brg, "i", $barang_id);
        mysqli_stmt_execute($stmt_brg);
        $res_brg = mysqli_stmt_get_result($stmt_brg);
        $row_brg = mysqli_fetch_assoc($res_brg);

        if ($row_brg) {
            $harga = $row_brg['harga'];

            $stmt_ins = mysqli_prepare($koneksi, "INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt_ins, "iiii", $transaksi_id, $barang_id, $harga, $qty);
            mysqli_stmt_execute($stmt_ins);

            $query_total = "UPDATE transaksi 
                            SET total = (SELECT IFNULL(SUM(harga * qty), 0) FROM transaksi_detail WHERE transaksi_id = ?) 
                            WHERE id = ?";
            $stmt_upd = mysqli_prepare($koneksi, $query_total);
            mysqli_stmt_bind_param($stmt_upd, "ii", $transaksi_id, $transaksi_id);
            mysqli_stmt_execute($stmt_upd);

            header("Location: transaksi_detail.php?id=" . $transaksi_id . "&status=sukses");
            exit;
        }
    } else {
        $pesan = "Data input tidak valid!";
    }
}

$stmt_trx = mysqli_prepare($koneksi, "
    SELECT t.id, t.waktu_transaksi, t.keterangan, t.total, p.nama AS nama_pelanggan 
    FROM transaksi t 
    JOIN pelanggan p ON t.pelanggan_id = p.id 
    WHERE t.id = ?
");
mysqli_stmt_bind_param($stmt_trx, "i", $transaksi_id);
mysqli_stmt_execute($stmt_trx);
$data_master = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt_trx));

$stmt_det = mysqli_prepare($koneksi, "
    SELECT td.transaksi_id, td.barang_id, b.kode_barang, b.nama_barang, td.harga, td.qty, (td.harga * td.qty) AS subtotal 
    FROM transaksi_detail td 
    JOIN barang b ON td.barang_id = b.id 
    WHERE td.transaksi_id = ?
");
mysqli_stmt_bind_param($stmt_det, "i", $transaksi_id);
mysqli_stmt_execute($stmt_det);
$res_detail = mysqli_stmt_get_result($stmt_det);

$used_items = [];
$res_used = mysqli_query($koneksi, "SELECT barang_id FROM transaksi_detail WHERE transaksi_id = $transaksi_id");
while ($r = mysqli_fetch_assoc($res_used)) {
    $used_items[] = (int)$r['barang_id'];
}

$res_all_barang = mysqli_query($koneksi, "SELECT id, kode_barang, nama_barang, harga FROM barang ORDER BY nama_barang ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Master Detail Transaksi</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 25px; line-height: 1.5; }
        .card { border: 1px solid #ccc; padding: 18px; border-radius: 6px; margin-bottom: 22px; background: #fafafa; }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        th, td { border: 1px solid #bbb; padding: 9px; text-align: left; }
        th { background: #eaeaea; }
        .text-right { text-align: right; }
        .nav-trx { margin-bottom: 15px; }
        .badge { background: #007bff; color: white; padding: 3px 8px; border-radius: 4px; font-size: 13px; }
    </style>
</head>
<body>

    <div class="nav-trx">
        <label><strong>Pilih ID Transaksi Master:</strong></label>
        <select onchange="window.location.href='transaksi_detail.php?id=' + this.value">
            <?php
            $trx_list = mysqli_query($koneksi, "SELECT id FROM transaksi ORDER BY id ASC");
            while ($trx = mysqli_fetch_assoc($trx_list)) {
                $sel = ($trx['id'] == $transaksi_id) ? 'selected' : '';
                echo "<option value='{$trx['id']}' $sel>Transaksi #{$trx['id']}</option>";
            }
            ?>
        </select>
        | <a href="barang.php">Kelola Data Barang &raquo;</a>
    </div>

    <div class="card">
        <h2>Data Master: Transaksi #<?= htmlspecialchars($data_master['id'] ?? '') ?></h2>
        <p><strong>Pelanggan:</strong> <?= htmlspecialchars($data_master['nama_pelanggan'] ?? '-') ?></p>
        <p><strong>Waktu Transaksi:</strong> <?= htmlspecialchars($data_master['waktu_transaksi'] ?? '-') ?></p>
        <p><strong>Keterangan:</strong> <?= htmlspecialchars($data_master['keterangan'] ?? '-') ?></p>
        <p><strong>Total Akumulasi:</strong> <span class="badge">Rp <?= number_format($data_master['total'] ?? 0, 0, ',', '.') ?></span></p>
    </div>

    <div class="card">
        <h3>Tambah Item ke Transaksi</h3>
        <?php if (!empty($pesan)): ?>
            <p style="color: red;"><?= $pesan ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="barang_id">Barang:</label>
            <select name="barang_id" id="barang_id" required>
                <option value="">-- Pilih Barang --</option>
                <?php while ($b = mysqli_fetch_assoc($res_all_barang)): ?>
                    <?php $is_used = in_array((int)$b['id'], $used_items); ?>
                    <option value="<?= $b['id'] ?>" <?= $is_used ? 'disabled style="color: #999;"' : '' ?>>
                        <?= htmlspecialchars($b['kode_barang']) ?> - <?= htmlspecialchars($b['nama_barang']) ?> (Rp <?= number_format($b['harga'], 0, ',', '.') ?>)
                        <?= $is_used ? ' [Sudah diinput]' : '' ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label for="qty" style="margin-left: 15px;">Jumlah (Qty):</label>
            <input type="number" name="qty" id="qty" min="1" value="1" required style="width: 70px;">

            <button type="submit" name="tambah_detail" style="margin-left: 15px; padding: 5px 12px;">Simpan Detail</button>
        </form>
    </div>

    <h3>Rincian Barang (Data Detail)</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th class="text-right">Harga</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            if (mysqli_num_rows($res_detail) > 0): 
                while ($item = mysqli_fetch_assoc($res_detail)): 
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($item['kode_barang']) ?></td>
                    <td><?= htmlspecialchars($item['nama_barang']) ?></td>
                    <td class="text-right">Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                    <td class="text-right"><?= $item['qty'] ?></td>
                    <td class="text-right">Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                </tr>
            <?php 
                endwhile;
            else: 
            ?>
                <tr>
                    <td colspan="6" style="text-align: center; color: #888;">Belum ada item detail untuk transaksi ini.</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="text-right">Total Transaksi:</th>
                <th class="text-right">Rp <?= number_format($data_master['total'] ?? 0, 0, ',', '.') ?></th>
            </tr>
        </tfoot>
    </table>

</body>
</html>