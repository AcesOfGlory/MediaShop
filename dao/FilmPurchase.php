<?php

require_once("DAO.php");

class FilmPurchase extends DAO {
    private $table = "fss_FilmPurchase";

    public function __construct() {
        parent::__construct($this->table);
    }
}

?>
