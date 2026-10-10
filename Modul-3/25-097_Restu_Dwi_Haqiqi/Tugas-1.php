<?php
// soal 1.1
$fruits = array("Avocado", "Blueberry", "Cherry");

// Menambahkan 5 data baru
array_push($fruits, "Durian", "Elderberry", "Fig", "Grape", "Honeydew");

echo 'fruits = ("';
$total = count($fruits);
for ($i = 0; $i < $total; $i++) {
    echo $fruits[$i];
    if ($i < $total - 1) {
        echo '", "';
    }
}
echo '") <br> Nilai dengan indeks tertinggi: ' . $fruits[$total - 1] . "<br>";

// soal 1.2
unset($fruits[1]);

$fruits = array_values($fruits);

echo "<br>Data Blueberry dihapus.<br>";
echo 'fruits = ("';
$total = count($fruits);
for ($i = 0; $i < $total; $i++) {
    echo $fruits[$i];
    if ($i < $total - 1) {
        echo '", "';
    }
}
echo '") <br>Nilai dengan indeks tertinggi: ' . $fruits[$total - 1];
?>