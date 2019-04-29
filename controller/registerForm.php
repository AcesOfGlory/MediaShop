<?php

include("../dao/Address.php");
include("../dao/Customer.php");
include("validation.php");

$emailEntered = test_input($_POST['email']);
$passwordEntered = test_input($_POST['password']);

function error(){
  header("Location: ../view/register.php");
  exit;
}

if (!emailValidation($emailEntered)) {
  error();
}
if (!passwordValidation($passwordEntered)){
  error();
}

$address = new Address();
$customer = new Customer();
$doesExist = $customer->isExistingCustomer($emailEntered);

if ($doesExist){
  header("Location: ../view/register.php");
  exit;
}
else {
  $personid = $customer->addAndGetPerson($emailEntered)["personid"];
  $customer->addCustomer($personid, $passwordEntered);

  $addid = $address->addAndGetAddress()["addid"];
  $address->addCustomerAddress($addid, $personid);

  header("Location: ../view/login.php");
  exit;
}

?>
