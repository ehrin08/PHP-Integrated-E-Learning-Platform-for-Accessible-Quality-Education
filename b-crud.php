<?php

require_once 'b-crudBase.php';

class crud extends databaseConn
{
    private $accountTable = "account";
    private $materialsTable = "learning_materials";
    private $feedbacksTable = "feedback";

    public $id;
    public $username = 'ehrin';
    public $email;
    public $password;
    public $title;

    private $conn;

    public function __construct()
    {
        // Establish database connection using inherited method
        $this->conn = $this->connect();
    }

    public function showLogs(){
        echo $this->username;
    }

    public function signUp()
    {
        $query = "INSERT INTO " . $this->accountTable . " (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);

        return $stmt->execute();
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

?>
