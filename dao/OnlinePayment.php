<?php

require_once("DAO.php");

class OnlinePayment extends DAO {
    private $table = "fss_OnlinePayment";

    public function __construct() {
        parent::__construct($this->table);
    }
}

?>
