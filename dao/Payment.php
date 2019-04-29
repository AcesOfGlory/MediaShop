<?php

require_once("DAO.php");

class Payment extends DAO {
    private $table = "fss_Payment";

    public function __construct() {
        parent::__construct($this->table);
    }

    public function addPayment($totalAmount){
      $queryAddPayment = sprintf("
      	INSERT
      	INTO
      	  fss_Payment(amount, paydate, shopid, ptid)
      	VALUES('%s', '%s', '%s', '%s')"
      	, $totalAmount
      	, date("Y-m-d")
      	, 1
      	, 2
      );
      parent::query($queryAddPayment);
    }

    public function getPayment(){
      $queryGetPayment = "
        SELECT
          payid
        FROM
          fss_Payment
        ORDER BY
          payid DESC
        LIMIT 1
      ";
      return parent::query($queryGetPayment);
    }

    public function addAndGetPayment($totalAmount){
      $this->addPayment($totalAmount);
      return $this->getPayment()->fetch_assoc();
    }
}

?>
