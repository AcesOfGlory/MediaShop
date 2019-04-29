<?php

include("../model/ShoppingBasket.php");
include("../model/CustomerSession.php");

include_once("../dao/Address.php");
include_once("../dao/Customer.php");
include_once("../dao/Payment.php");
include_once("../dao/CardPayment.php");
include_once("../dao/OnlinePayment.php");
include_once("../dao/OnlinePurchase.php");
include_once("../dao/FilmPurchase.php");
include_once("../dao/DVDStock.php");

session_start();

$basket = $_SESSION['shoppingbasket'];
$cust = $_SESSION['customer'];

if (!isset($basket)){
  header("Location: ../view/index.php");
  exit;
}
if (!isset($cust)){
  header("Location: ../view/login.php");
  exit;
}

$cno = $_POST['cno'];
$ctype = $_POST['ctype'];
$cexprEntered = $_POST['cexpr'];

$date = preg_split("/-/", $cexprEntered);
$year = substr($date[0], -2);
$month = $date[1];
$cexpr = "$month:$year";

$PRICE = 5;
$custid = $cust->getCustomer();
$totalAmount = $basket->getTotalCount() * PRICE;

$address = new Address();
$payment = new Payment();
$cardPayment = new CardPayment();
$onlinePayment = new OnlinePayment();
$onlinePurchase = new OnlinePurchase();
$filmPurchase = new FilmPurchase();
$DVDStock = new DVDStock();

$payid = $payment->addAndGetPayment($totalAmount)["payid"];
$cardPayment->addCardPayment($payid, $cno, $ctype, $cexpr);
$onlinePayment->addOnlinePayment($payid, $custid);

foreach ($basket->getItems() as $filmid => $quantity) {
	$DVDStock->updateDVDStock($filmid, $quantity);

  for ($i = 0; $i < $quantity; $i++){
  	$fpid = $filmPurchase->addAndGetFilmPurchase($payid, $filmid)["fpid"];
  	$addid = $address->getCustomerAddress($custid)["addid"];
  	$onlinePurchase->addOnlinePurchase($fpid, $addid);
  }
}
$basket->emptyBasket();

header("Location: ../view/basket.php");
exit;

?>
