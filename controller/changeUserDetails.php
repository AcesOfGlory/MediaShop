<?php

include("../model/CustomerSession.php");
include("../controller/validation.php");
include("../dao/Customer.php");
include("../dao/Address.php");

session_start();

if (!isset($_SESSION['customer'])){
  header("Location: ../login.php");
  exit;
}

$custid = $_SESSION['customer']->getCustomer();

$nameEntered = test_input($_POST['name']);
$phoneEntered = test_input($_POST['phone']);
$emailEntered = test_input($_POST['email']);
$passwordEntered = test_input($_POST['password']);
$streetEntered = test_input($_POST['street']);
$cityEntered = test_input($_POST['city']);
$postcodeEntered = test_input($_POST['postcode']);

function error(){
  header("Location: ../view/account/user-details.php");
  exit;
}

function regexValidation($string, $pattern){
  if (!preg_match($string, $pattern)){
    error();
  }
}

regexValidation("/^[a-zA-Z ]*$/", $nameEntered);
regexValidation("/^(\d{11})?$/", $phoneEntered);

if (!emailValidation($emailEntered)) {
  error();
}
if (!passwordValidation($passwordEntered)){
  error();
}

regexValidation("/^[a-zA-Z\d\.\- ]*$/", $streetEntered);
regexValidation("/^[a-zA-Z ]*$/", $cityEntered);
regexValidation("/^[a-zA-Z\d ]*$/", $postcodeEntered);

$address = new Address();
$customer = new Customer();

$customer->updatePerson($custid, $nameEntered, $phoneEntered, $emailEntered);
$customer->updateCustomer($custid, $passwordEntered);
$address->updateAddress($custid, $streetEntered, $cityEntered, $postcodeEntered);

header("Location: ../view/account/user-details.php");
exit;
?>
