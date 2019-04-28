<?php

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function passwordValidation($password){
  return preg_match("/^[a-zA-Z\d]{4,}$/", $password);
}

function emailValidation($email){
  return filter_var($email, FILTER_VALIDATE_EMAIL);
}


?>
