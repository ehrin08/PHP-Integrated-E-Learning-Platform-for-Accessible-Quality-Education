<?php

require_once 'dbConnection.php';

abstract class CrudBase
{
    protected $conn;

    public function __construct()
    {
        $db = new DatabaseConn();
        $this->conn = $db->connect();
    }

    protected function executeQuery($query, $params = [])
    {
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $exception) {
            echo "Query error: " . $exception->getMessage();
            return false;
        }
    }
}

?>
