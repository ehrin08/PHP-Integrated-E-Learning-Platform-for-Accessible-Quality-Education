<?php

class Database {
    private $conn;

    public function __construct($hostname, $username, $password, $dbname) {
        $this->conn = new mysqli($hostname, $username, $password, $dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}

$db = new Database("localhost", "root", "", "qualityeduc");
$conn = $db->getConnection();
?>
