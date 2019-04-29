<?php

include("../model/CustomerSession.php");
include("../dao/Customer.php");

$emailEntered = $_POST['email'];
$passwordEntered = $_POST['password'];

$customer = new Customer();
$customerDetails = $customer->getCustomer($emailEntered);

$custidFetched = $customerDetails["custid"];
$emailFetched = $customerDetails["personemail"];
$passwordFetched = $customerDetails["custpassword"];

if ($emailEntered != $emailFetched || $passwordEntered != $passwordFetched) {
  header("Location: ../view/login.php");
  exit;
}

session_start();

$user = new CustomerSession();
$user->setCustomerLogin(true);
$user->setCustomer($custidFetched);

$_SESSION["customer"] = $user;

header("Location: ../view/index.php");
exit;

?>
