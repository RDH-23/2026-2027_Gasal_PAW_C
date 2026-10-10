<?php
// soal 4.1
$height = array("Andy" => "176", "Barry" => "165", "Charlie" => "170");

// Menambahkan 5 data baru
$height["David"] = "180";
$height["Ethan"] = "172";
$height["Frank"] = "168";
$height["George"] = "175";
$height["Harry"] = "182";

foreach ($height as $name => $h) {
    echo $name . " is " . $h . " cm tall.<br>";
}

echo "<br>";

// soal 4.2
$weight = array("Andy" => "70", "Barry" => "65", "Charlie" => "75");

$keys = array_keys($weight);
$values = array_values($weight);

for ($i = 0; $i < count($weight); $i++) {
    echo $keys[$i] . " is " . $values[$i] . " kg.<br>";
}
?>