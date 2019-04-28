<?php

include("CustomerSession.php");
include("dao/Customer.php");

$emailEntered = $_POST['email'];
$passwordEntered = $_POST['password'];

$queryGetCustomer =
"SELECT
  custid,
  personemail,
  custpassword
FROM
  fss_Person
INNER JOIN
  fss_Customer ON(personid = custid)
WHERE
  personemail = '$emailEntered'";


$customer = new Customer();
$customerDetails = $customer->query($queryGetCustomer)->fetch_assoc();

$custidFetched = $customerDetails["custid"];
$emailFetched = $customerDetails["personemail"];
$passwordFetched = $customerDetails["custpassword"];

if ($emailEntered != $emailFetched || $passwordEntered != $passwordFetched) {
  header("Location: login.php");
  exit;
}

session_start();

$user = new CustomerSession();
$user->setCustomerLogin(true);
$user->setCustomer($custidFetched);

$_SESSION["customer"] = $user;

header("Location: index.php");
exit;

?>
