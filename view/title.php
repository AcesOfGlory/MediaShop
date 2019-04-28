<?php

include("../model/CustomerSession.php");
include("layout/header.php");
require_once("../dao/Film.php");

$filmId = $_GET["id"];
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

$filmDAO = new Film();
$film = $filmDAO->query($queryGetFilm)->fetch_assoc();

if ($film) {
  echo "<title>{$film['filmtitle']}</title>";

  echo "<h1>{$film['filmtitle']}</h1><br/>";
  echo "<h5><b>Rating:</b> {$film['filmrating']}</h5>";
  echo "<h5><b>Description:</b> {$film['filmdescription']}</h5><br/>";

  echo
    "<form action='../controller/addToBasket.php' method=post>
        <input type='hidden' name='id' value='$filmId'>
        <input type='submit' class='button-right' value='Add to Basket'>
      </form>
    ";
}
else {
	echo "<p><h3>Can't find any films.</h3></p>";
}

?>
