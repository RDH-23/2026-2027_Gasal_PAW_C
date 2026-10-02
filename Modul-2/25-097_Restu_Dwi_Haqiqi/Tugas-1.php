<?php 

$matkul = ["PTI","ALPRO","DPW","STRUKDAT","JARKOM","PAW","PSBF","RPL"];
$praktikum = ["JARKOM","PAW"];

for ($i=0; $i < count($matkul); $i++) { 
	for ($j=0; $j < count($praktikum) ; $j++) { 
		$flag = false;

		if ($matkul[$i] === $praktikum[$j]) {
			$flag = true;
		};
	}

	if ($flag === true) {
		echo "Saya sedang mengambil matkul " . $matkul[$i] . " termasuk praktikumnya<br>";
	} else if (($i === 6) || ($i === 7)) {
		echo "Saya belum mengambil matkul " . $matkul[$i] . "<br>";
	} else {
		echo "Saya sudah mengambil matkul " . $matkul[$i] . " semester lalu<br>";
	};
};


?>