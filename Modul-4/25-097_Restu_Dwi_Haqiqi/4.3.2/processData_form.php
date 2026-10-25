<!DOCTYPE html>
<html>
<head>
    <title>Form Processing</title>
</head>
<body>

<?php
/*
	$errors = array();
	if (isset($_POST['surname'])) 
	{
		require 'validate.inc';
		foreach ($_POST as $keypost => $valuepost) {
			validateName($errors, $_POST, $keypost);
		}

		if ($errors)
			{
				echo '<h1>Invalid, correct the following errors:</h1>';
				foreach ($errors as $field => $error)
				echo "$field $error</br>";
				// tampilkan kembali form
				include 'form.inc';
			}
		else {
			echo 'Form submitted successfully with no errors';
				echo "<br>";
				foreach ($_POST as $key => $value) {
				echo "($key) => ($value) <br>";
			}
		} 
	} else
	// tampilkan kembali form
	include 'form.inc';
*/

// Langkah 9 - 4.3.2
$errors = array();

if (isset($_POST['submit']) || isset($_POST['surname'])) {
    require_once 'validate.inc';

    $fieldsToValidate = ['surname', 'email', 'passwd', 'address', 'state', 'sex'];

    foreach ($fieldsToValidate as $field) {
        validateField($errors, $_POST, $field);
    }

    if ($errors) {
        echo '<h1>Invalid, correct the following errors:</h1>';
        foreach ($errors as $field => $error) {
            echo htmlspecialchars($field) . " " . htmlspecialchars($error) . "<br/>";
        }
        include 'form.inc';
    } else {
        echo 'Form submitted successfully with no errors';
        echo "<br>";
        foreach ($_POST as $key => $value) {
            echo "(" . htmlspecialchars($key) . ") => (" . htmlspecialchars($value) . ") <br>";
        }
    }
} else {
    include 'form.inc';
}

?>

</body>
</html>