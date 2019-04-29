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

    public function getFilmName($filmid){
      $queryGetFilmName = "
        SELECT
          filmtitle
        FROM
          fss_Film
        WHERE
          filmid = '$filmid'
      ";
      return parent::query($queryGetFilmName)->fetch_assoc()["filmtitle"];
    }

    public function getFilm($filmid){
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
          F.ratid = R.ratid AND filmid = '$filmid'
      ";
      return parent::query($queryGetFilm)->fetch_assoc();
    }

    public function searchFilmsSortedByFilmID($searchTerm){
      $queryFilmIDSearch = "
        SELECT
          *
        FROM
          fss_Film
        WHERE
          filmtitle LIKE '$searchTerm'
      ";
      return parent::query($queryFilmIDSearch);
    }

    public function searchFilmsSortedByFilmTitle($searchTerm, $order){
      $queryFilmTitleASCSearch = "
        SELECT
          *
        FROM
          fss_Film
        WHERE
          filmtitle LIKE '$searchTerm'
        ORDER BY
          filmtitle $order
      ";
      return parent::query($queryFilmTitleASCSearch);
    }

    public function searchFilmsSortedByFilmTitleASC($searchTerm){
      return $this->searchFilmsSortedByFilmTitle($searchTerm, "ASC");
    }

    public function searchFilmsSortedByFilmTitleDESC($searchTerm){
      return $this->searchFilmsSortedByFilmTitle($searchTerm, "DESC");
    }
}

?>
