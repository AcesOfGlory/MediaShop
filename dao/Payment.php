<?php

require_once("DAO.php");

class Payment extends DAO {
    private $table = "fss_Payment";

    public function __construct() {
        parent::__construct($this->table);
    }
}

?>
