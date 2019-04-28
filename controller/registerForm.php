<?php

include("dao/Customer.php");
include("validation.php");

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
  personemail,
  personid
FROM
  fss_Person
WHERE
  personemail = '$emailEntered'";

$queryAddPerson =
  "INSERT
  INTO
    fss_Person(personemail)
  VALUES('$emailEntered')";

$customer = new Customer();
$doesExist = $customer->query($queryCheckExists)->num_rows;


if ($doesExist != 0){
  header("Location: register.php");
  exit;
}
else {
  $customer->query($queryAddPerson);

  $newCustomer = $customer->query($queryCheckExists)->fetch_assoc();
  $personid = $newCustomer["personid"];

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

  $customer->query($queryAddCustomer);

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

  $customer->query($queryAddAddress);

  $addressQuery = $customer->query($queryGetAddress)->fetch_assoc();
  $addid = $addressQuery["addid"];

  $queryAddCustomerAddress =
    "INSERT
    INTO
      fss_CustomerAddress(addid, custid)
    VALUES('$addid', '$personid')";

  $customer->query($queryAddCustomerAddress);

  header("Location: login.php");
  exit;
}

?>
