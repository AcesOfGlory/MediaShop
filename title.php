<?php

include("CustomerSession.php");
include("header.php");

$host = "localhost";
$user = "u1762930";
$pass = "27dec98";
$db = "u1762930";

$connection = new mysqli($host, $user, $pass, $db);

$filmId = $_GET['id'];

$queryGetFilm = "
SELECT
  filmid,
  filmtitle,
  filmdescription,
  filmrating
FROM
  fss_Film F
INNER JOIN
  fss_Rating R
WHERE
  F.ratid = R.ratid AND filmid = '$filmId'
";

$stmt = $connection->query($queryGetFilm) or die($connection->error);
$film = $stmt->fetch_array();

if ($film) {
  echo "<title>{$film['filmtitle']}</title>";

  echo "<h1>{$film['filmtitle']}</h1><br/>";
  echo "<h5> Rating: {$film['filmrating']}</h5>";
  echo "<h5> Description: {$film['filmdescription']}</h5><br/>";

  echo
    "<form action='addToBasket.php' method=post>
        <input type='hidden' name='id' value='$filmId'>
        <input type='submit' class='button-right' value='Add to Basket'>
      </form>
    ";
}
else {
	echo "<p><h3>Can't find any films.</h3></p>";
}

?>
