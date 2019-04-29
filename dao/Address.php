<?php

require_once("DAO.php");

class Address extends DAO {
    private $table = "fss_Address";

    public function __construct() {
        parent::__construct($this->table);
    }

    public function addAddress(){
      $queryAddAddress = "
        INSERT
        INTO
          fss_Address()
        VALUES()
      ";
      parent::query($queryAddAddress);
    }

    public function getAddress(){
      $queryGetAddress = "
        SELECT
          addid
        FROM
          fss_Address
        ORDER BY
          addid DESC
        LIMIT 1
      ";
      return parent::query($queryGetAddress);
    }

    public function addAndGetAddress(){
      $this->addAddress();
      return $this->getAddress()->fetch_assoc();
    }

    public function addCustomerAddress($addid, $personid){
      $queryAddCustomerAddress = "
        INSERT
        INTO
          fss_CustomerAddress(addid, custid)
        VALUES('$addid', '$personid')
      ";
      parent::query($queryAddCustomerAddress);
    }

    public function getCustomerAddress($custid){
      $queryGetCustomerAddress = "
        SELECT
          addid
        FROM
          fss_CustomerAddress
        WHERE
          custid = '$custid'
      ";
      return parent::query($queryGetCustomerAddress)->fetch_assoc();
    }

    public function updateAddress($custid, $street, $city, $postcode){
      $queryUpdateAddress = "
        UPDATE
          fss_Address A
        SET
          A.addstreet = '$street',
          A.addcity = '$city',
          A.addpostcode = '$postcode'
        WHERE
          (
          SELECT
            CA.addid
          FROM
            fss_CustomerAddress CA
          WHERE
            A.addid = CA.addid AND CA.custid = '$custid'
        )";
        parent::query($queryUpdateAddress);
    }
}

?>
