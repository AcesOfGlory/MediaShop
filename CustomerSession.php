<?php
class CustomerSession
{
    	public $user = "";
    	private $loggedIn;

    	function __construct() { $this->loggedIn = False; }

    	function setCustomerLogin($loggedIn){$this->loggedIn = $loggedIn;}
    	function getCustomerLogin() { return $this->loggedIn; }

    	function setCustomer($user) { $this->user = $user; }
    	function getCustomer() { return $this->user; }
}
?>
