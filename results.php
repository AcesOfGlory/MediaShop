<?php

include("customerSession.php");
include("header.php");
require_once("dao/Film.php");

$searchTerm = $_GET['search_query'];
$sortedBy = $_GET['sort'];
$sortType = $_GET['type'];

$filmDAO = new Film();

if ($sortType == "first"){
  $searchTermPattern = "$searchTerm%";
}
else if ($sortType == "exact"){
  $searchTermPattern = "$searchTerm";
}
else if ($sortType == "last"){
  $searchTermPattern = "%$searchTerm";
}
else {
  $searchTermPattern = "%$searchTerm%";
}

$query1 = "
SELECT
  *
FROM
  fss_Film
WHERE
  filmtitle LIKE '$searchTermPattern'
";

$query2 = "
SELECT
  *
FROM
  fss_Film
WHERE
  filmtitle LIKE '$searchTermPattern'
ORDER BY
  filmtitle ASC
";

$query3 = "
SELECT
  *
FROM
  fss_Film
WHERE
  filmtitle LIKE '$searchTermPattern'
ORDER BY
  filmtitle DESC
";

if ($sortedBy == "asc"){
  $sql = $query2;
}
elseif ($sortedBy == "desc"){
  $sql = $query3;
}
else {
  $sql = $query1;
}

$stmt = $filmDAO->query($sql);
$film = $stmt->fetch_array();

echo "
<form method='get'>
    <input type='hidden' name='search_query' value='$searchTerm'>

    <label>Sort By: </label>
    <select name='sort' class='sort-box'>
      <option selected value='id'>Film ID</option>
      <option value='asc'>Film Name (Ascending)</option>
      <option value='desc'>Film Name (Descending)</option>
    </select>

    <label>Sort Type: </label>
    <select name='type' class='sort-box'>
      <option value='similar'>Similar</option>
      <option value='first'>Match First Characters</option>
      <option value='last'>Match Last Characters</option>
      <option value='exact'>Exact</option>
    </select>
    <input type='submit' value='Sort'>
</form>
";

?>


<!DOCTYPE HTML>
<html>
  <head>
    <title>Search results</title>
  </head>
  <body>
      <h3> Results: </h3>
      <br/>
<?php

if ($film){
	do {
    echo "
      <h4><a href='title.php?id={$film["filmid"]}'>{$film["filmtitle"]}</a></h4>
    ";
	} while ($film = $stmt->fetch_array());
}
else {
	echo "<h4>No search results.</h4>";
}

?>

  </body class="search">
</html>
