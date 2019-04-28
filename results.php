<?php

include("CustomerSession.php");
include("header.php");

$host = "localhost";
$user = "u1762930";
$pass = "27dec98";
$db = "u1762930";

$conn = new mysqli($host, $user, $pass, $db);


$searchTerm = $_GET['search_query'];
$sortedBy = $_GET['sort'];
$sortType = $_GET['type'];

$query1 = "
SELECT
  *
FROM
  fss_Film
WHERE
  filmtitle LIKE ?
";

$query2 = "
SELECT
  *
FROM
  fss_Film
WHERE
  filmtitle LIKE ?
ORDER BY
  filmtitle ASC
";

$query3 = "
SELECT
  *
FROM
  fss_Film
WHERE
  filmtitle LIKE ?
ORDER BY
  filmtitle DESC
";


if ($sortedBy == "asc"){
    $stmt = $conn->prepare($query2);
}
elseif ($sortedBy == "desc"){
    $stmt = $conn->prepare($query3);
}
else {
    $stmt = $conn->prepare($query1);
}

$searchPattern = "";

if ($sortType == "first"){
    $searchPattern = "$searchTerm%";
}
else if ($sortType == "exact"){
    $searchPattern = "$searchTerm";
}
else if ($sortType == "last"){
    $searchPattern = "%$searchTerm";
}
else {
    $searchPattern = "%$searchTerm%";
}

$stmt->bind_param("s",$searchPattern);
$stmt->execute();
$films = $stmt->get_result();


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
<main>
    <h3> Results: </h3>
    <br/>
</main>

<?php

if ($films){

    foreach ($films as $film) {
        echo "
      <h4><a href='title.php?id={$film["filmid"]}'>{$film["filmtitle"]}</a></h4>
    ";
    }
}
else {
    echo "<h4>No search results</h4>";
}

?>
</body class="search">
</html>
