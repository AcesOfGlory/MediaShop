<?php

require_once("DAO.php");

class DVDStock extends DAO {
    private $table = "fss_DVDStock";

    public function __construct() {
        parent::__construct($this->table);
    }
}

?>
