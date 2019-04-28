<?php

function getRandomFilm(){
  $host = "localhost";
  $user = "u1762930";
  $pass = "27dec98";
  $db = "u1762930";

  $connection = new mysqli($host, $user, $pass, $db);
  $stmt = $connection->query("SELECT filmid FROM fss_Film ORDER BY RAND() LIMIT 1") or die($connection->error);

  return $stmt->fetch_array()['filmid'];
}

?>
