<?php

include("../model/ShoppingBasket.php");

session_start();

$id = $_POST['id'];

if (!isset($_SESSION['shoppingbasket'])){
	$basket = new ShoppingBasket();
	$_SESSION['shoppingbasket'] = $basket;
}

$_SESSION['shoppingbasket']->addItem($id);

header("Location: ../view/title.php?id=$id");
exit;

?>
