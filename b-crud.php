<?php

class crud
{
    private $conn; //connection
    private $accountTable = "account"; //account table
    private $materialsTable = "learning_materials";

    public $id;
    public $username;
    public $email;
    public $password;
    public $title;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function signUp()
    {

        $query = "INSERT INTO " . $this->accountTable . " (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function login()
    {
        $query = "SELECT * FROM " . $this->accountTable;
        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        $num = $stmt->rowCount();

        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if ($this->email == htmlspecialchars($row['email']) && $this->password == htmlspecialchars($row['password'])) {
                    session_start();
                    $_SESSION['username'] = $row['username'];
                    return true;
                }
            }
        }
        return false;
    }

    public function uploadFile($title, $fileData, $uploader, $accountId)
    {
        $query = "INSERT INTO " . $this->materialsTable . " (title, document, contributor, account_id) VALUES (:title, :document, :contributor, :account_id)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':document', $fileData, PDO::PARAM_LOB); // For blob
        $stmt->bindParam(':contributor', $uploader);
        $stmt->bindParam(':account_id', $accountId);

        return $stmt->execute();
    }

    public function readFile($accountId)
    {
        $query = "SELECT material_id, title, contributor, upload_date 
                  FROM " . $this->materialsTable . " 
                  WHERE account_id = :account_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':account_id', $accountId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAllFiles() {
        $query = "SELECT material_id, title, contributor, upload_date FROM " . $this->materialsTable;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function getFile($material_id)
    {
        $query = "SELECT title, document FROM " . $this->materialsTable . " WHERE material_id = :material_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':material_id', $material_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
