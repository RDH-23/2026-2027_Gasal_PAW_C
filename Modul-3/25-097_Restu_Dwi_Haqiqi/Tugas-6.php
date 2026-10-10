<?php  

// array push
$data1 = array('A');
array_push($data1, 'B');
echo "Hasil array_push: " . implode(" ", $data1) . "<br>";


// array merge
$data2 = array('C');
$merge = array_merge($data1,$data2);
echo "Hasil array_merge: " . implode(" ", $merge) . "<br>";

// array_values
$arr_1 = array('x' => 1 ,'y' => 2 );
$val = array_values($arr_1);
echo "Hasil array_values: " . implode(" ", $val) . "<br>";

// array search
$result = array_search("B", $merge);
echo "Hasil array_search: " . $result . "<br>";

// array_filter
$arr_2 = array(0,1,false,2,"",3,"array");
$hasil = array_filter($arr_2);
echo "Hasil array_filter: " . implode(" ", $hasil) . "<br><br>";


// sorting array terindeks
$numbers = array(3,2,1);
echo "Array awal: " . implode(" ", $numbers) . "<br>";

$s_num = $numbers;
sort($s_num);
echo "Hasil sort: " . implode(" ", $s_num) . "<br>";

$rs_num = $numbers;
rsort($rs_num);
echo "Hasil rsort: " . implode(" ", $rs_num) . "<br><br>";


// sorting array asosiatif
$age = array('Peter' => 35, 'Ben' => 37, 'Joe' => 43);
echo "Array awal: ";
foreach ($age as $n => $a) {
	echo "$n => $a, ";
}
echo "<br>";

$as = $age;
asort($as);
echo "Hasil asort: ";
foreach ($as as $n => $a) {
	echo "$n => $a, ";
}
echo "<br>";

$ks = $age;
ksort($ks);
echo "Hasil asort: ";
foreach ($ks as $n => $a) {
	echo "$n => $a, ";
}
echo "<br>";

$ars = $age;
arsort($ars);
echo "Hasil asort: ";
foreach ($ars as $n => $a) {
	echo "$n => $a, ";
}
echo "<br>";

$krs = $age;
krsort($krs);
echo "Hasil asort: ";
foreach ($krs as $n => $a) {
	echo "$n => $a, ";
}
echo "<br>";


?>