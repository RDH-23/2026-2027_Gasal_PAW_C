<?php
include 'koneksi.php';
$id = intval($_GET['id'] ?? 0);
mysqli_query($koneksi, "DELETE FROM supplier WHERE id = $id");
header("Location: index.php");
exit();
?>