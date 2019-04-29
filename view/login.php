<?php
include("../model/CustomerSession.php");
include("layout/header.php");
?>

<html>
  <head>
    <title>Login Form</title>
  </head>

  <body>
    <center>
      <h1>Log in</h1>
      </br>
      <table>
        <form action='../controller/loginForm.php' method=post>
            <tr><td>Email</td><td><input required type=email name='email'></td></tr>
            <tr><td>Password</td><td><input required type=password name='password'></td></tr>
            <tr><td></td><td></td></tr>
            <tr><td><input type="submit" value="Submit"></td>
            <td><input type="reset" value="Reset"></td></tr>
        </form>
      </table>
    </center>
  </body>
</html>
