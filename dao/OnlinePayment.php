<?php

require_once("DAO.php");

class OnlinePayment extends DAO {
    private $table = "fss_OnlinePayment";

    public function __construct() {
        parent::__construct($this->table);
    }

    public function addOnlinePayment($payid, $custid){
      $queryAddOnlinePayment = sprintf("
      	INSERT
      	INTO
      	  fss_OnlinePayment(payid, custid)
      	VALUES('%s', '%s')"
      	, $payid
      	, $custid
      );
      parent::query($queryAddOnlinePayment);
    }

    public function getOnlinePayments($custid){
      $queryGetOnlinePayments = "
        SELECT
          F.filmid,
          F.filmtitle,
          FP.price,
          Pa.paydate,
          OP.payid
        FROM
          fss_OnlinePayment OP
        INNER JOIN
          fss_Person P ON(P.personid = OP.custid)
        INNER JOIN
          fss_FilmPurchase FP ON(FP.payid = OP.payid)
        INNER JOIN
          fss_Film F ON(F.filmid = FP.filmid)
        INNER JOIN
          fss_Payment Pa ON(FP.payid = Pa.payid)
        WHERE
          P.personid = '$custid'
        ORDER BY
          OP.payid ASC
      ";
      return parent::query($queryGetOnlinePayments);
    }
}

?>
