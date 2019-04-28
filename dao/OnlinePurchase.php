<?php

require_once("DAO.php");

class OnlinePurchase extends DAO {
    private $table = "fss_OnlinePurchase";

    public function __construct() {
        parent::__construct($this->table);
    }
}

?>
