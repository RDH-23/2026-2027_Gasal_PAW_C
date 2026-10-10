<?php
// soal 2.1
$fruits = array("Avocado", "Blueberry", "Cherry");

$additional = array("Mangga", "Melon", "Semangka", "Pir", "Pepaya");
for ($i = 0; $i < count($additional); $i++) {
    $fruits[] = $additional[$i];
}

$arrlength = count($fruits);
echo "Panjang array saat ini: " . $arrlength . "<br><br>";

for ($x = 0; $x < $arrlength; $x++) {
    echo $fruits[$x] . "<br>";
}


echo "<br>";

// soal 2.2
$vegies = array("Carrot", "Broccoli", "Spinach");

for ($i = 0; $i < count($vegies); $i++) {
    echo $vegies[$i] . "<br>";
}

?>