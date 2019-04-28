<?php

require_once("../dao/Film.php");

$film = new Film();
$randomFilm = $film->getRandomFilm();

header("Location: /u1762930/MediaShop/view/title.php?id=$randomFilm");
exit;

?>
