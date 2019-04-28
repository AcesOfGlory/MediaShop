<?php

include("../CustomerSession.php");
include("../validation.php");

$host = "localhost";
$user = "u1762930";
$pass = "27dec98";
$db = "u1762930";

$connection = new mysqli($host, $user, $pass, $db);

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
  header("Location: user-details.php");
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

$queryUpdatePerson =
"UPDATE
  fss_Person P
SET
  P.personname = '$nameEntered',
  P.personphone = '$phoneEntered',
  P.personemail = '$emailEntered'
WHERE
  P.personid = '$custid'";


$queryUpdateCustomer =
"UPDATE
  fss_Customer C
SET
  C.custpassword = '$passwordEntered'
WHERE
  C.custid = '$custid'";

$queryUpdateAddress =
"UPDATE
  fss_Address A
SET
  A.addstreet = '$streetEntered',
  A.addcity = '$cityEntered',
  A.addpostcode = '$postcodeEntered'
WHERE
  (
  SELECT
    CA.addid
  FROM
    fss_CustomerAddress CA
  WHERE
    A.addid = CA.addid AND CA.custid = '$custid'
)";


$connection->query($queryUpdatePerson) or die($connection->error);
$connection->query($queryUpdateCustomer) or die($connection->error);
$connection->query($queryUpdateAddress) or die($connection->error);

header("Location: user-details.php");
exit;
?>
