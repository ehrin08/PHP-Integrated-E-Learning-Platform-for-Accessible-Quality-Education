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

    public function uploadFile($title, $fileData, $uploader) {
        $query = "INSERT INTO " . $this->materialsTable . " (title, document, contributor) VALUES (:title, :document, :contributor)";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':document', $fileData, PDO::PARAM_LOB); // For binary data
        $stmt->bindParam(':contributor', $uploader);
    
        return $stmt->execute();
    }

    public function readFile() {
        $query = "SELECT material_id, title, contributor, upload_date FROM " . $this->materialsTable;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function getFile($material_id) {
        $query = "SELECT title, document FROM " . $this->materialsTable . " WHERE material_id = :material_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':material_id', $material_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
<<<<<<< Updated upstream
    
=======

    public function getAccountIdByUsername($username)
    {
        $query = "SELECT account_id FROM " . $this->accountTable . " WHERE username = :username";
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
        return $stmt->execute(); // Returns true if successful, false otherwise
    }


    public function deleteFile($material_id): bool
    {
        $query = "DELETE FROM " . $this->materialsTable . " WHERE material_id = :material_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':material_id', $material_id, PDO::PARAM_INT);
        return $stmt->execute(); 
    }

>>>>>>> Stashed changes
}
