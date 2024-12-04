<?php
session_start();
require_once 'dbConnection.php';
require_once 'b-crud.php';

if (!isset($_SESSION['username'])) {
    header('Location: edit.php');
    exit();
}

if (isset($_GET['material_id'])) {
    $material_id = intval($_GET['material_id']);
    $database = new databaseConn();
    $conn = $database->connect();
    $crud = new Crud($conn);

    $file = $crud->getFile($material_id);

    if (!$file) {
        echo "File not found.";
        exit();
    }
} else {
    echo "No material ID specified.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newTitle = $_POST['title'] ?? $file['title'];
    $newFileData = isset($_FILES['document']) && $_FILES['document']['tmp_name'] 
        ? file_get_contents($_FILES['document']['tmp_name']) 
        : null;

    $query = "UPDATE learning_materials SET title = :title";
    if ($newFileData) {
        $query .= ", document = :document";
    }
    $query .= " WHERE material_id = :material_id";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':title', $newTitle);
    if ($newFileData) {
        $stmt->bindParam(':document', $newFileData, PDO::PARAM_LOB);
    }
    $stmt->bindParam(':material_id', $material_id);

    if ($stmt->execute()) {
        header('Location: upload.php');
        exit();
    } else {
        echo "Failed to update the file.";
    }
}
?>