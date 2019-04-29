<?php

require_once("DAO.php");

class FilmPurchase extends DAO {
    private $table = "fss_FilmPurchase";

    public function __construct() {
        parent::__construct($this->table);
    }

    public function addFilmPurchase($payid, $filmid){
      $queryAddFilmPurchase = sprintf("
        INSERT
        INTO
          fss_FilmPurchase(payid, filmid, shopid, price)
        VALUES('%s', '%s', '%s', '%s')"
        , $payid
        , $filmid
        , 1
        , 5
      );
      parent::query($queryAddFilmPurchase);
    }

    public function getFilmPurchase(){
      $queryGetFilmPurchase = "
        SELECT
          fpid
        FROM
          fss_FilmPurchase
        ORDER BY
          fpid DESC
        LIMIT 1
      ";
      return parent::query($queryGetFilmPurchase);
    }

    public function addAndGetFilmPurchase($payid, $filmid){
      $this->addFilmPurchase($payid, $filmid);
      return $this->getFilmPurchase()->fetch_assoc();
    }
}

?>
