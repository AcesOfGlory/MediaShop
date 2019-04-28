<?php
include("CustomerSession.php");
include("header.php");
?>

<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
  <title>Registration Form</title>

</head>
<body>
	<h1>Register</h1>
	<table>
    <form action='registerForm.php' method=post>
        <tr><td>Email</td><td><input required type=email name='email'></td></tr>
        <tr><td>Password</td><td><input required type=password name='password'></td></tr>
        
        <tr><td><input type="submit" value="Submit"></td>
        <td><input type="reset" value="Reset"></td></tr>
    </form>
	</table>

</body>
</html>
