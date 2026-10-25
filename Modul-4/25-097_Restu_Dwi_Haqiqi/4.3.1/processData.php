<h3>Posted data:</h3>
<?php

// Langkah 2
// require 'validate.inc';
// if (validateName($_POST, 'surname')) {
// 	echo 'Data OK!';
// } else {
// 	echo 'Data invalid!';
// }

// Langkah 5
require 'validate.inc'; 
$errors = array();
validateName($errors, $_POST, 'surname'); 
if ($errors) {
	echo 'Errors:<br/>';
	foreach ($errors as $field => $error)
	echo "$field $error</br>";
} else
	echo 'Data OK!';
	echo '<br>';

echo "<br>";
foreach ($_POST as $key => $value) {
	echo "($key) => ($value) <br>";
}

?>