<?php
session_start();

include_once 'connection.php';

class UserAuth
{
    private $conn;
    private $username;
    private $password;
    private $category;

    public function __construct($conn, $username, $password, $category)
    {
        $this->conn = $conn;
        $this->username = $conn->real_escape_string($username);
        $this->password = $conn->real_escape_string($password);
        $this->category = $conn->real_escape_string($category);
    }

    public function authenticate()
    {
        $allowedCategories = ['student', 'contributor'];

        if (!in_array($this->category, $allowedCategories)) {
            die("Invalid category.");
        }

        $stmt = $this->conn->prepare("SELECT * FROM $this->category WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $this->username, $this->password);

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['username'] = $this->username;
            header("Location: home.php");
            exit();
        } else {
            echo "Invalid username or password.";
        }

        $stmt->close();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $auth = new UserAuth($conn, $_POST['username'], $_POST['password'], $_POST['category']);
    $auth->authenticate();
    $conn->close();
}
