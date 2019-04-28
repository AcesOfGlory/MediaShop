<?php

require_once("DAO.php");

class CardPayment extends DAO {
    private $table = "fss_CardPayment";

    public function __construct() {
        parent::__construct($this->table);
    }
}

?>
