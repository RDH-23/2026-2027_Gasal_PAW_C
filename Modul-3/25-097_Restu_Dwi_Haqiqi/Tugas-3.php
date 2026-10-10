<?php
// soal 3.1
$height = array("Andy" => "176", "Barry" => "165", "Charlie" => "170");

// Menambahkan 5 data baru
$height["David"] = "180";
$height["Ethan"] = "172";
$height["Frank"] = "168";
$height["George"] = "175";
$height["Harry"] = "182";

echo 'height = ("';
$keys = array_keys($height);
$total = count($keys);
for ($i = 0; $i < $total; $i++) {
    $k = $keys[$i];
    echo $k . '"=>"' . $height[$k];
    if ($i < $total - 1) {
        echo '", "';
    }
}
echo '") <br>Nilai dengan indeks terakhir: ' . end($height) . "<br>";

unset($height["Barry"]);

echo 'height = ("';
$keys = array_keys($height);
$total = count($keys);
for ($i = 0; $i < $total; $i++) {
    $k = $keys[$i];
    echo $k . '"=>"' . $height[$k];
    if ($i < $total - 1) {
        echo '", "';
    }
}
echo '") <br>Nilai dengan indeks terakhir setelah dihapus: ' . end($height) . "<br><br>";

// soal 3.2
$weight = array("Andy" => "70", "Barry" => "65", "Charlie" => "75");
$values = array_values($weight);

echo 'weight = ("Andy"=>"70", "Barry"=>"65", "Charlie"=>"75")<br>';
echo "Data kedua: " . $values[1];
?>