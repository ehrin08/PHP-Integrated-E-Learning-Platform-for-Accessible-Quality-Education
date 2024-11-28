<?php

class databaseConn {
    private $dbHost = "localhost";
    private $dbName = "qualityeduc";
    private $dbUsername = "root";
    private $dbPassword = "";
    public $conn;

    public function connect() {
        $this->conn = null;

        try {

            $this->conn = new PDO("mysql:host=" . $this->dbHost . ";dbname=" . $this->dbName, $this->dbUsername, $this->dbPassword);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}

?>
