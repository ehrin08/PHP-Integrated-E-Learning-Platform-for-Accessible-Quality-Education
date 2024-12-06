<?php

class crud
{
    private $conn;
    private $accountTable = "account"; 
    private $materialsTable = "learning_materials";
    private $feedbacksTable = "feedback";

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
        $stmt->bindParam(':document', $fileData, PDO::PARAM_LOB); 
        $stmt->bindParam(':contributor', $uploader);
        $stmt->bindParam(':account_id', $accountId);

        return $stmt->execute();
    }

    public function readFile($accountId)
    {
        $query = "SELECT * FROM " . $this->materialsTable . " WHERE account_id = :account_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':account_id', $accountId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAllFiles()
    {
        $query = "SELECT * FROM " . $this->materialsTable;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getFile($material_id)
    {
        $query = "SELECT * FROM " . $this->materialsTable . " WHERE material_id = :material_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':material_id', $material_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAccountIdByUsername($username)
    {
        $query = "SELECT * FROM " . $this->accountTable . " WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ? $user['account_id'] : null; 
    }
    public function deleteFile($material_id): bool
    {
        $query = "DELETE FROM " . $this->materialsTable . " WHERE material_id = :material_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':material_id', $material_id, PDO::PARAM_INT);
        return $stmt->execute(); 
    }

    public function updateFile($material_id, $title, $fileData = null)
    {
        $query = "UPDATE " . $this->materialsTable . " SET title = :title";

        if ($fileData !== null) {
            $query .= ", document = :document";
        }

        $query .= " WHERE material_id = :material_id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':title', $title);
        if ($fileData !== null) {
            $stmt->bindParam(':document', $fileData, PDO::PARAM_LOB);
        }
        $stmt->bindParam(':material_id', $material_id, PDO::PARAM_INT);

        return $stmt->execute();
    }
    
}