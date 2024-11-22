<?php
session_start();
include_once 'connection.php';

class User {
    private $username;

    public function __construct() {
        if (!isset($_SESSION['username'])) {
            header("Location: login.php");
            exit();
        }
        $this->username = htmlspecialchars($_SESSION['username']);
    }

    public function getUsername() {
        return $this->username;
    }
}

class FileUpload {
    private $conn;
    private $file;
    private $fileType;
    private $username;
    private $title;

    public function __construct($conn, $fileType, $file, $username, $title) {
        if ($conn instanceof mysqli) {
            $this->conn = $conn;
        } else {
            throw new Exception('Invalid database connection');
        }

        $this->file = $file;
        $this->fileType = $fileType;
        $this->username = $username;
        $this->title = $title;
    }

    public function upload() {
        if ($this->file['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['pdf', 'video', 'picture'];
            //$extension = pathinfo($this->file['name'], PATHINFO_EXTENSION);
            if (!in_array($this->fileType, $allowedTypes)) {
                header("Location: home.php?status=error");
                exit();
            }

            $fileContent = file_get_contents($this->file['tmp_name']);
            $fileContent = $this->conn->real_escape_string($fileContent);

            $stmt = $this->conn->prepare("INSERT INTO learning_materials (type, document, contributor, title) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $this->fileType, $fileContent, $this->username, $this->title);

            if ($stmt->execute()) {
                header("Location: home.php?status=success");
                exit();
            } else {
                header("Location: home.php?status=error");
                exit();
            }

            $stmt->close();
        } else {
            header("Location: home.php?status=file_error");
            exit();
        }
    }

    public function delete($material_id) {
        $stmt = $this->conn->prepare("DELETE FROM learning_materials WHERE material_id = ?");
        $stmt->bind_param("i", $material_id);

        if ($stmt->execute()) {
            header("Location: home.php?status=deleted");
            exit();
        } else {
            header("Location: home.php?status=error");
            exit();
        }

        $stmt->close();
    }
}

$user = new User();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['document'])) {
        $fileUpload = new FileUpload($conn, $_POST['fileType'], $_FILES['document'], $user->getUsername(), $_POST['title']);
        $fileUpload->upload();
    }

    if (isset($_POST['delete_material_id']) && isset($_POST['delete'])) {
        $fileUpload = new FileUpload($conn, '', '', $user->getUsername(), '');
        $fileUpload->delete($_POST['delete_material_id']);
    }
}

$conn->close();
?>
