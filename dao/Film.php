<?php

require_once("DAO.php");

class Film extends DAO {
    private $table = "fss_Film";

    public function __construct() {
        parent::__construct($this->table);
    }

    public function getRandomFilm(){
      $randomFilmQuery = parent::query("SELECT filmid FROM fss_Film ORDER BY RAND() LIMIT 1");
      $randomFilm = $randomFilmQuery->fetch_assoc()["filmid"];

      return $randomFilm;
    }
}

?>
