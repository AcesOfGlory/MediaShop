<?php

include("../CustomerSession.php");
include("../header.php");

$host = "localhost";
$user = "u1762930";
$pass = "27dec98";
$db = "u1762930";

session_start();

if (!isset($_SESSION['customer'])){
  header("Location: ../login.php");
  exit;
}

$connection = new mysqli($host, $user, $pass, $db);

$custid = $_SESSION['customer']->getCustomer();

$query = "
SELECT
  F.filmid,
  F.filmtitle,
  FP.price,
  Pa.paydate,
  OP.payid
FROM
  fss_OnlinePayment OP
INNER JOIN
  fss_Person P ON(P.personid = OP.custid)
INNER JOIN
  fss_FilmPurchase FP ON(FP.payid = OP.payid)
INNER JOIN
  fss_Film F ON(F.filmid = FP.filmid)
INNER JOIN
  fss_Payment Pa ON(FP.payid = Pa.payid)
WHERE
  P.personid = '$custid'
ORDER BY
  OP.payid ASC";

$result1 = $connection->query($query) or die($connection->error);

print "<center>";
print "<h1>Order History</h1><br/>";

print "<table border=1>";
print "<tr>
          <td><h4>Film Title</h4></td>
          <td><h4>Price</h4></td>
          <td><h4>Date</h4></td>
          <td><h4>Order Number</h4></td></tr>";

while ($row = $result1->fetch_row()){
  print "<tr>";
  $i = 0;
  $filmid = $row[0];

  foreach ($row as $field){
    if ($i == 0)
      ;
    else if ($i == 1)
      print "<td><a href='../title.php?id=$filmid'>$field</a></td>";
    else if ($i == 2)
      print "<td>£$field</td>";
    else
      print "<td>$field</td>";

    $i++;
  }
  print "</tr>";
}
print "</table>";
print "</center>";

?>

<head>
  <title>Order History</title>
</head>
