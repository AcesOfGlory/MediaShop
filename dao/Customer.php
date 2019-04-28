<?php

require_once("DAO.php");

class Customer extends DAO {
    private $table = "fss_Customer";

    public function __construct() {
        parent::__construct($this->table);
    }
}

?>
