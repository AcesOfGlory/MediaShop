<?php

include("CustomerSession.php");

$host = "localhost";
$user = "u1762930";
$pass = "27dec98";
$db = "u1762930";

$connection = new mysqli($host, $user, $pass, $db);

$emailEntered = $_POST['email'];
$passwordEntered = $_POST['password'];

$sql =
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

$result1 = $connection->query($sql) or die($connection->error);
$result2 = $result1->fetch_object();

$custidFetched = $result2->custid;
$emailFetched = $result2->personemail;
$passwordFetched = $result2->custpassword;


if ($emailEntered != $emailFetched || $passwordEntered != $passwordFetched) {
  header("Location: login.php");
  exit;
}

session_start();

$user = new CustomerSession();
$user->setCustomerLogin(true);
$user->setCustomer($custidFetched);

$_SESSION['customer'] = $user;

header("Location: index.php");
exit;

?>
