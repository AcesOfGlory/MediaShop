<?php

include("CustomerSession.php");
include("ShoppingBasket.php");

include("header.php");
require_once("dao/Film.php");

session_start();

$filmDAO = new Film();

if (!isset($_SESSION['shoppingbasket'])){
	$basket = new ShoppingBasket();
	$_SESSION['shoppingbasket'] = $basket;
}

$basket = $_SESSION['shoppingbasket'];

echo "<center>";
echo "<h2>Basket</h2><br/>";

echo "<table border=1>";
echo "</tr><td><h4>Film Name</h4></td><td><h4>Quantity</h4></td><td><h4>Price</h4></td></tr>";

foreach ($basket->getItems() as $f => $q) {
	$query ="
	SELECT
	  filmtitle
	FROM
	  fss_Film
	WHERE
	  filmid = '$f'
	";

	$result = $filmDAO->query($query);
	$fi = $result->fetch_object()->filmtitle;

	$price = $q * 5;

	echo "<tr>
					<td><a href='title.php?id=$f'>$fi</a></td>
					<td>
						<form method='post' id='quantity'>
							<input type='hidden' name='filmid' value='$f'/>
							<input type='number' readonly min='0' max='10' name='changeQuantity' value='$q'
											oninput=\"document.getElementById('quantity').submit();\">
						</form>
					</td>
					<td>£$price</td>
				</tr>";
}
echo "</table>";
echo "</center>";


if(isset($_POST['clearBasket'])){
    clearBasket();
}

if(isset($_POST['changeQuantity'])){
    changeQuantity();
}

function changeQuantity(){
	$filmid = $_POST['filmid'];
	$quantity = $_POST['changeQuantity'];


	$_SESSION['shoppingbasket']->setQuantity($filmid, $quantity);

	// $after = $_SESSION['shoppingbasket']->getQuantity($idSplit[0]);

	header("Location: basket.php");
	exit;
}

function clearBasket(){
	$_SESSION['shoppingbasket']->emptyBasket();

	header("Location: basket.php");
	exit;
}

if (!$_SESSION['shoppingbasket']->isEmpty()){
	$price = $_SESSION['shoppingbasket']->getTotalCount() * 5;

	echo "
		<center>
			<p>
				</br><h4>Total: £$price</h4>
				</p>
		</center>
	";

	echo "
		<p>
			<center>
				<table>
					<tr><td><form method='post'>
					    <input type='hidden' name='clearBasket'>
					    <input type='submit' value='Clear Basket'>
					</form></td>

					<td><form method='post' action='checkout.php'>
					    <input type='submit' value='Checkout'>
					</form></td></tr>
				</table>
			</center>
		</p>
	";
}
?>


<html>
	<head>
		<title>Basket</title>
	</head>
</html>
