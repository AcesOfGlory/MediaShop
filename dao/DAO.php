<?php

require("Connection.php");

class DAO extends Connection {
    private $table;
    private $connection;

    public function __construct($table) {
        $this->connection = parent::__construct();
        $this->table = $table;
    }

    public function getTable() {
        return $this->table;
    }

    public function getConnection() {
        return $this->connection;
    }
}
