<?php

include("../resources/configs.php");

class Connection {
    private $connection;
    private $host = "localhost";//$config["db"]["host"];
    private $user = "u1762930";//$config["db"]["username"];
    private $pass = "27dec98";//$config["db"]["password"];
    private $db ="u1762930";//$config["db"]["dbname"];

    public function __construct(){
        $this->connection = new mysqli($this->host, $this->user, $this->pass, $this->db);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
        return $this->connection;
    }

    public function __destruct() {
        $this->connection->close();
    }

    public function getConnection() {
        return $this->connection;
    }

    public function query($sql) {
        $result = $this->connection->query($sql) or die($this->connection->error);
        if ($result === FALSE) {
            echo "Query failed: " . $this->connection->error;
        }
        else {
            return $result;
        }
    }
}

?>
