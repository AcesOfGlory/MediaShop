<?php

include("ShoppingBasket.php");
include("CustomerSession.php");

include_once("dao/Customer.php");
include_once("dao/Payment.php");
include_once("dao/CardPayment.php");
include_once("dao/OnlinePayment.php");
include_once("dao/OnlinePurchase.php");
include_once("dao/FilmPurchase.php");
include_once("dao/DVDStock.php");

session_start();

$basket = $_SESSION['shoppingbasket'];
$cust = $_SESSION['customer'];

if (!isset($basket)){
  header("Location: index.php");
  exit;
}
if (!isset($cust)){
  header("Location: login.php");
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

$customer = new Customer();
$payment = new Payment();
$cardPayment = new CardPayment();
$onlinePayment = new OnlinePayment();
$onlinePurchase = new OnlinePurchase();
$filmPurchase = new FilmPurchase();
$DVDStock = new DVDStock();


$queryAddPayment = sprintf('
	INSERT
	INTO
	  fss_Payment(amount, paydate, shopid, ptid)
	VALUES("%s", "%s", "%s", "%s")'
	, $totalAmount
	, date("Y-m-d")
	, 1
	, 2
);
$payment->query($queryAddPayment);

$queryGetPaymentID = "SELECT payid FROM fss_Payment ORDER BY payid DESC LIMIT 1";
$queryGetPaymentIDResult = $payment->query($queryGetPaymentID);
$payid = $queryGetPaymentIDResult->fetch_object()->payid;


$queryAddCardPayment = sprintf("
	INSERT
	INTO
	  fss_CardPayment(payid, cno, ctype, cexpr)
	VALUES('%s', '%s', '%s', '%s')"
	, $payid
	, $cno
	, $ctype
	, $cexpr
);
$cardPayment->query($queryAddCardPayment);


$queryAddOnlinePayment = sprintf("
	INSERT
	INTO
	  fss_OnlinePayment(payid, custid)
	VALUES('%s', '%s')"
	, $payid
	, $custid
);
$onlinePayment->query($queryAddOnlinePayment);


foreach ($basket->getItems() as $f => $q) {

	$queryUpdateStock = "
		UPDATE
		  fss_DVDStock
		SET
		  stocklevel = stocklevel - $q
		WHERE
		  shopid = 1 AND filmid = '$f'
	";
	$DVDStock->query($queryUpdateStock);

  for ($i = 0; $i < $q; $i++){

  	$queryAddFilmPurchase = sprintf("
  		INSERT
  		INTO
  		  fss_FilmPurchase(payid, filmid, shopid, price)
  		VALUES('%s', '%s', '%s', '%s')"
  		, $payid
  		, $f
  		, 1
  		, 5
  	);
  	$filmPurchase->query($queryAddFilmPurchase);

  	$queryGetFilmPurchaseID = "SELECT fpid FROM fss_FilmPurchase ORDER BY fpid DESC LIMIT 1";
  	$queryGetFilmPurchaseIDResult = $filmPurchase->query($queryGetFilmPurchaseID);
  	$fpid = $queryGetFilmPurchaseIDResult->fetch_object()->fpid;


  	$queryGetAddressID = "SELECT addid FROM fss_CustomerAddress WHERE custid = '$custid'";
  	$queryGetAddressIDResult = $customer->query($queryGetAddressID);
  	$addid = $queryGetAddressIDResult->fetch_object()->addid;

  	$queryAddOnlinePurchase = sprintf("
  		INSERT
  		INTO
  		  fss_OnlinePurchase(fpid, addid)
  		VALUES('%s', '%s')"
  		, $fpid
  		, $addid
  	);
  	$onlinePurchase->query($queryAddOnlinePurchase);
  }
}

$basket->emptyBasket();

header("Location: basket.php");
exit;

?>
