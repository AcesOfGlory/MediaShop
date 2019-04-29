<?php

require_once("DAO.php");

class CardPayment extends DAO {
    private $table = "fss_CardPayment";

    public function __construct() {
        parent::__construct($this->table);
    }

    public function addCardPayment($payid, $cno, $ctype, $cexpr){
      $queryAddCardPayment = sprintf("
      	INSERT
      	INTO
      	  fss_CardPayment(payid, cno, ctype, cexpr)
      	VALUES('%s', '%s', '%s', '%s')"
      	, $payid
      	, $cno
      	, $ctype
      	, $cexpr
      );
      parent::query($queryAddCardPayment);
    }
}

?>
