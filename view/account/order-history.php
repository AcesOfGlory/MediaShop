<?php

include("../../model/CustomerSession.php");
include("../layout/header.php");

include_once("../../dao/OnlinePayment.php");

session_start();

if (!isset($_SESSION['customer'])){
  header("Location: ../login.php");
  exit;
}

$custid = $_SESSION['customer']->getCustomer();

$onlinePayment = new OnlinePayment();
$result1 = $onlinePayment->getOnlinePayments($custid);

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
