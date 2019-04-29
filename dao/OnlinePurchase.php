<?php

require_once("DAO.php");

class OnlinePurchase extends DAO {
    private $table = "fss_OnlinePurchase";

    public function __construct() {
        parent::__construct($this->table);
    }

    public function addOnlinePurchase($fpid, $addid){
      $queryAddOnlinePurchase = sprintf("
        INSERT
        INTO
          fss_OnlinePurchase(fpid, addid)
        VALUES('%s', '%s')"
        , $fpid
        , $addid
      );
      parent::query($queryAddOnlinePurchase);
    }
}

?>
