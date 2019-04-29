<?php

include("layout/header.php");

session_start();

if (!isset($_SESSION['shoppingbasket'])){
  header("Location: index.php");
  exit;
}
if (!isset($_SESSION['customer'])){
  header("Location: login.php");
  exit;
}

?>

<html>
  <head>
    <title>Checkout</title>
  </head>

  <body>
    <center>
      <h1>Checkout</h1>
      <br/>
      <p>
        <h5>Please enter card details below: </h5>
      </p>
      <br/>
      <table>
        <form action='../controller/checkoutForm.php' method=post>
            <tr><td>Card Number</td><td><input required type=number name='cno' min=0 oninput="validity.valid||(value='');"></td></tr>

            <tr><td>Card Type</td><td>
              <select name='ctype'>
                <option selected value='American Express'>American Express</option>
                <option value='Carte Blanche'>Carte Blanche</option>
                <option value='Diners Club'>Diners Club</option>
                <option value='Discover'>Discover</option>
                <option value='enRoute'>enRoute</option>
                <option value='JCB'>JCB</option>
                <option value='Laser'>Laser</option>
                <option value='Maestro'>Maestro</option>
                <option value='MasterCard'>MasterCard</option>
                <option value='Solo'>Solo</option>
                <option value='Switch'>Switch</option>
                <option value='Visa'>Visa</option>
                <option value='Visa Electron'>Visa Electron</option>
              </select>
            </td></tr>

            <tr><td>Card Expiry Date</td><td><input required type=month name='cexpr' min='2019-04' max='2050-12'></td></tr>
            <tr><td></td><td></td></tr>
            <tr><td><input type="submit" value="Submit"></td>
            <td><input type="reset" value="Reset"></td></tr>
        </form>
      </table>
    </center>
  </body>
</html>
