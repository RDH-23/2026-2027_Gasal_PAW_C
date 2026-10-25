<?php

// Langkah 1
// function validateName($field_list, $field_name) {
// 	if (!isset($field_list[$field_name]))
// 		return false;

// 	$pattern = "/^[a-zA-Z'-]+$/"; // format nama (alfabet)
// 	if (!preg_match($pattern, $field_list[$field_name]))
// 		return false;
// 	return true;
// }

// Langkah 4 & 6 (Kode Lama)
/*
function validateName(&$errors, $field_list, $field_name)
{
	if ($field_name == "surname") {
		$pattern = "/^[a-zA-Z'-]+$/"; // format surname (alfabet)
		if (!isset($field_list[$field_name]) || empty($field_list[$field_name])) {
			$errors[$field_name] = 'required';
		}
		else if (!preg_match($pattern, $field_list[$field_name])){
			$errors[$field_name] = 'invalid';
		}
	} else if ($field_name == "email"){		
		if (!isset($field_list[$field_name]) || empty($field_list[$field_name])) {
			$errors[$field_name] = 'required';
		}
		else if (!filter_var($field_list[$field_name],FILTER_VALIDATE_EMAIL)){
			$errors[$field_name] = 'invalid';
		}
	} else if ($field_name == "state") {
		if ($field_list[$field_name] == -1) {
			$errors[$field_name] = 'invalid';
		}
	} else {
		if (!isset($field_list[$field_name]) || empty($field_list[$field_name])) {
			$errors[$field_name] = 'required';
		}
	}
}
*/

// Langkah 9 - 4.3.2 
function validateField(&$errors, $field_list, $field_name)
{
	switch ($field_name) {
		case "surname":
			$pattern = "/^[a-zA-Z'-]+$/"; // format surname (alfabet)
			if (!isset($field_list[$field_name]) || trim($field_list[$field_name]) === '') {
				$errors[$field_name] = 'required';
			} else if (!preg_match($pattern, trim($field_list[$field_name]))) {
				$errors[$field_name] = 'invalid';
			}
			break;

		case "email":
			if (!isset($field_list[$field_name]) || trim($field_list[$field_name]) === '') {
				$errors[$field_name] = 'required';
			} else if (!filter_var($field_list[$field_name], FILTER_VALIDATE_EMAIL)) {
				$errors[$field_name] = 'invalid';
			}
			break;

		case "passwd":
			if (!isset($field_list[$field_name]) || trim($field_list[$field_name]) === '') {
				$errors[$field_name] = 'required';
			} else if (strlen($field_list[$field_name]) < 6) {
				$errors[$field_name] = 'invalid (minimal 6 karakter)';
			}
			break;

		case "address":
			if (!isset($field_list[$field_name]) || trim($field_list[$field_name]) === '') {
				$errors[$field_name] = 'required';
			} else if (strlen(trim($field_list[$field_name])) < 5) {
				$errors[$field_name] = 'invalid (minimal 5 karakter)';
			}
			break;

		case "state":
			if (!isset($field_list[$field_name]) || $field_list[$field_name] == "-1" || empty($field_list[$field_name])) {
				$errors[$field_name] = 'invalid';
			}
			break;

		case "sex":
			if (!isset($field_list[$field_name]) || empty($field_list[$field_name])) {
				$errors[$field_name] = 'required';
			} else if (!in_array($field_list[$field_name], ['male', 'female'])) {
				$errors[$field_name] = 'invalid';
			}
			break;

		default:
			if (!isset($field_list[$field_name]) || trim($field_list[$field_name]) === '') {
				$errors[$field_name] = 'required';
			}
			break;
	}
}

function validateName(&$errors, $field_list, $field_name)
{
	validateField($errors, $field_list, $field_name);
}

?>