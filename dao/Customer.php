<?php

require_once("DAO.php");

class Customer extends DAO {
    private $table = "fss_Customer";

    public function __construct() {
        parent::__construct($this->table);
    }

    public function addPerson($email){
      $queryAddPerson = "
        INSERT
        INTO
          fss_Person(personemail)
        VALUES('$email')
      ";

      parent::query($queryAddPerson);
    }

    public function getPerson($email){
      $queryGetPerson = "
        SELECT
          personemail,
          personid
        FROM
          fss_Person
        WHERE
          personemail = '$email'
      ";

      $getPerson = parent::query($queryGetPerson);
      return $getPerson;
    }

    public function findCustomer($email){
      $queryGetCustomer = "
        SELECT
          custid,
          personemail,
          custpassword
        FROM
          fss_Person
        INNER JOIN
          fss_Customer ON(personid = custid)
        WHERE
          personemail = '$email'
      ";

      $customerDetails = parent::query($queryGetCustomer);
      return $customerDetails;
    }

    public function getCustomer($email){
      return $this->findCustomer($email)->fetch_assoc();
    }

    public function addCustomer($personid, $password){
      $queryAddCustomer = sprintf("
          INSERT
          INTO
            fss_Customer(custid, custregdate, custendreg, custpassword)
          VALUES('%s', '%s', '%s', '%s')"
          , $personid,
            date("Y-m-d"),
            date("2050-m-d"),
            $password
      );

      parent::query($queryAddCustomer);
    }

    public function isExistingCustomer($email){
      return $this->findCustomer($email)->num_rows != 0;
    }

    public function addAndGetPerson($email){
      $this->addPerson($email);
      return $this->getPerson($email)->fetch_assoc();
    }

    public function updatePerson($custid, $name, $phone, $email){
      $queryUpdatePerson = "
        UPDATE
          fss_Person P
        SET
          P.personname = '$name',
          P.personphone = '$phone',
          P.personemail = '$email'
        WHERE
          P.personid = '$custid'
      ";
      parent::query($queryUpdatePerson);
    }

    public function updateCustomer($custid, $password){
      $queryUpdateCustomer = "
        UPDATE
          fss_Customer C
        SET
          C.custpassword = '$password'
        WHERE
          C.custid = '$custid'
        ";
        parent::query($queryUpdateCustomer);
    }

    public function getUserDetails($custid){
      $queryGetUserDetails = "
        SELECT
          P.personname,
          P.personphone,
          P.personemail,
          C.custpassword,
          A.addstreet,
          A.addcity,
          A.addpostcode
        FROM
          fss_Customer C
        INNER JOIN
          fss_Person P ON(P.personid = C.custid)
        INNER JOIN
          fss_CustomerAddress CA ON(C.custid = CA.custid)
        INNER JOIN
          fss_Address A ON(A.addid = CA.addid)
        WHERE
          CA.custid = '$custid'
      ";
      return parent::query($queryGetUserDetails);
    }
}

?>
