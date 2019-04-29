<?php

require_once("DAO.php");

class DVDStock extends DAO {
    private $table = "fss_DVDStock";

    public function __construct() {
        parent::__construct($this->table);
    }

    public function updateDVDStock($filmid, $quantity){
      $queryUpdateStock = "
    		UPDATE
    		  fss_DVDStock
    		SET
    		  stocklevel = stocklevel - $quantity
    		WHERE
    		  shopid = 1 AND filmid = '$filmid'
      ";
      parent::query($queryUpdateStock);
    }
}

?>
