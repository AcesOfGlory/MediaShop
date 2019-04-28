<?php

require_once("dao/Film.php");

function getRandomFilm(){
  $film = new Film();
  return $film->getRandomFilm();
}


?>
