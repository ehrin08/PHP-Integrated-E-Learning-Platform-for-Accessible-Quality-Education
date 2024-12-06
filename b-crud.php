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

        // Hash the password
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

        $query = "INSERT INTO " . $this->accountTable . " (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $hashedPassword);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function login()
    {
        $query = "SELECT * FROM " . $this->accountTable . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':email', $this->email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($this->password, $user['password'])) {
            session_start();
            $_SESSION['username'] = $user['username'];
            return true;
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

    public function deleteFile($material_id)
    {
        $query = "DELETE FROM " . $this->materialsTable . " WHERE material_id = :material_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':material_id', $material_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function updateFile($material_id, $title, $fileData = null)
    {
        // Base query for updating the title
        $query = "UPDATE " . $this->materialsTable . " SET title = :title";

        // Add file update to the query only if file data is provided
        if ($fileData !== null) {
            $query .= ", document = :document";
        }

        $query .= " WHERE material_id = :material_id";

        // Prepare the statement
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':title', $title);
        if ($fileData !== null) {
            $stmt->bindParam(':document', $fileData, PDO::PARAM_LOB);
        }
        $stmt->bindParam(':material_id', $material_id, PDO::PARAM_INT);

        // Execute the query and return the result
        return $stmt->execute();
    }

    public function addFeedback($material_id, $comment, $contributor_name)
    {
        $query = "INSERT INTO " . $this->feedbacksTable . " (material_id, comment, contributors_name) VALUES (:material_id, :comment, :contributors_name)";
        $stmt = $this->conn->prepare($query);

        // Bind the parameters
        $stmt->bindParam(':material_id', $material_id, PDO::PARAM_INT);
        $stmt->bindParam(':comment', $comment);
        $stmt->bindParam(':contributors_name', $contributor_name);

        // Execute the query and check for success
        if ($stmt->execute()) {
            return true;
        } else {
            // Add error handling
            print_r($stmt->errorInfo());
            return false;
        }
    }


    public function getFeedbacks($material_id)
    {
        $query = "SELECT * FROM " . $this->feedbacksTable . " WHERE material_id = :material_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':material_id', $material_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
