<?php

include("../CustomerSession.php");
include("../header.php");
include("../dao/Customer.php");

session_start();

if (!isset($_SESSION['customer'])){
  header("Location: ../login.php");
  exit;
}

$custid = $_SESSION['customer']->getCustomer();
$customer = new Customer();

$queryGetUserDetails = "
  SELECT
    P.personname,
    P.personphone,
    P.personemail,
    C.custpassword,
    A.addstreet,
    A.addcity,
    A.addpostcode
  FROM
    fss_Customer C
  INNER JOIN
    fss_Person P ON(P.personid = C.custid)
  INNER JOIN
    fss_CustomerAddress CA ON(C.custid = CA.custid)
  INNER JOIN
    fss_Address A ON(A.addid = CA.addid)
  WHERE
    CA.custid = '$custid'
";

$result1 = $customer->query($queryGetUserDetails);
$row = $result1->fetch_row();

?>

<html>
  <head>
    <title>User Details</title>
  </head>

  <body>
    <center>
      <h1>User Details</h1><br/>

      <table>
        <form autocomplete='off' action='changeUserDetails.php' method=post>
            <input type="text" style="display:none">
            <input type="password" style="display:none">

            <tr><td>Name</td><td><input type=text name='name' value="<?php echo $row[0]; ?>"></td></tr>
            <tr><td>Phone</td><td><input type=text name='phone' value="<?php echo $row[1]; ?>"></td></tr>
            <tr><td>Email</td><td><input required type=email autocomplete='off' name='email' value="<?php echo $row[2]; ?>"></td></tr>

            <tr><td>Password</td><td><input required type=password autocomplete='off' name='password' value="<?php echo $row[3]; ?>"></td></tr>

            <tr><td>Street</td><td><input type=text name='street' value="<?php echo $row[4]; ?>"></td></tr>
            <tr><td>City</td><td><input type=text name='city' value="<?php echo $row[5]; ?>"></td></tr>
            <tr><td>Postcode</td><td><input type=text name='postcode' value="<?php echo $row[6]; ?>"></td></tr>

            <tr><td><input type='submit' value='Submit'></td>
          </form>
      </table>
    </center>
    <p>
  </body>
</html>
