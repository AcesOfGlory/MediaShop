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

    public function setTable($table) {
        $this->table = '`' . $table . '`';
    }

    public function getConnection() {
        return $this->connection;
    }

    public function getAll() {
        $films = array();
        $result = parent::query('SELECT * FROM ' . $this->table);
        while ($record = $result->fetch_object()) {
            array_push($films, $record);
        }
        return $films;
    }

    public function getAllFromTable($table) {
        $films = array();
        $result = parent::query('SELECT * FROM ' . $table);
        while ($record = $result->fetch_object()) {
            array_push($films, $record);
        }
        return $films;
    }
}
