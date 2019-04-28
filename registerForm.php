<?php
include("validation.php");

$host = "localhost";
$user = "u1762930";
$pass = "27dec98";
$db = "u1762930";

$connection = new mysqli($host, $user, $pass, $db);

$emailEntered = test_input($_POST['email']);
$passwordEntered = test_input($_POST['password']);

function error(){
  header("Location: register.php");
  exit;
}

if (!emailValidation($emailEntered)) {
  error();
}
if (!passwordValidation($passwordEntered)){
  error();
}

$queryCheckExists =
"SELECT
  personemail, personid
FROM
  fss_Person
WHERE
  personemail = '$emailEntered'";

$queryAddPerson =
  "INSERT
  INTO
    fss_Person(personemail)
  VALUES('$emailEntered')";


$result1 = $connection->query($queryCheckExists) or die($connection->error);
$result2 = $result1->fetch_object();

$emailFetched = $result2->personemail;


if ($emailEntered == $emailFetched){
  header("Location: register.html");
  exit;
}
else {
  $connection->query($queryAddPerson) or die($connection->error);

  $result3 = $connection->query($queryCheckExists) or die($connection->error);
  $result4 = $result3->fetch_object();
  $personid = $result4->personid;

  $queryAddCustomer = sprintf(
    'INSERT
    INTO
      fss_Customer(custid, custregdate, custendreg, custpassword)
    VALUES("%s", "%s", "%s", "%s")'
    , $personid,
      date("Y-m-d"),
      date("2050-m-d"),
      $passwordEntered
  );

  $connection->query($queryAddCustomer) or die($connection->error);

  $queryAddAddress =
  "INSERT
    INTO
      fss_Address()
    VALUES()";

  $queryGetAddress =
  "SELECT
      addid
    FROM
      fss_Address
    ORDER BY
      addid DESC
    LIMIT 1";


  $connection->query($queryAddAddress) or die($connection->error);

  $addressQuery = $connection->query($queryGetAddress) or die($connection->error);
  $addid = $addressQuery->fetch_object()->addid;

  $queryAddCustomerAddress =
    "INSERT
    INTO
      fss_CustomerAddress(addid, custid)
    VALUES('$addid', '$personid')";


  $connection->query($queryAddCustomerAddress) or die($connection->error);

  header("Location: login.php");
  exit;
}


?>
