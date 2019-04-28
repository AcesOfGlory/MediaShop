<?php

include("ShoppingBasket.php");
include("CustomerSession.php");

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

$host = "localhost";
$user = "u1762930";
$pass = "27dec98";
$db = "u1762930";

$connection = new mysqli($host, $user, $pass, $db);

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
$connection->query($queryAddPayment) or die($connection->error);

$queryGetPaymentID = "SELECT payid FROM fss_Payment ORDER BY payid DESC LIMIT 1";
$queryGetPaymentIDResult = $connection->query($queryGetPaymentID) or die($connection->error);
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
$connection->query($queryAddCardPayment) or die($connection->error);


$queryAddOnlinePayment = sprintf("
	INSERT
	INTO
	  fss_OnlinePayment(payid, custid)
	VALUES('%s', '%s')"
	, $payid
	, $custid
);
$connection->query($queryAddOnlinePayment) or die($connection->error);


foreach ($basket->getItems() as $f => $q) {

	$queryUpdateStock = "
		UPDATE
		  fss_DVDStock
		SET
		  stocklevel = stocklevel - $q
		WHERE
		  shopid = 1 AND filmid = '$f'
	";
	$connection->query($queryUpdateStock) or die($connection->error);

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
  	$connection->query($queryAddFilmPurchase) or die($connection->error);

  	$queryGetFilmPurchaseID = "SELECT fpid FROM fss_FilmPurchase ORDER BY fpid DESC LIMIT 1";
  	$queryGetFilmPurchaseIDResult = $connection->query($queryGetFilmPurchaseID) or die($connection->error);
  	$fpid = $queryGetFilmPurchaseIDResult->fetch_object()->fpid;


  	$queryGetAddressID = "SELECT addid FROM fss_CustomerAddress WHERE custid = '$custid'";
  	$queryGetAddressIDResult = $connection->query($queryGetAddressID) or die($connection->error);
  	$addid = $queryGetAddressIDResult->fetch_object()->addid;

  	$queryAddOnlinePurchase = sprintf("
  		INSERT
  		INTO
  		  fss_OnlinePurchase(fpid, addid)
  		VALUES('%s', '%s')"
  		, $fpid
  		, $addid
  	);
  	$connection->query($queryAddOnlinePurchase) or die($connection->error);
  }
}


$basket->emptyBasket();

header("Location: basket.php");
exit;

?>
