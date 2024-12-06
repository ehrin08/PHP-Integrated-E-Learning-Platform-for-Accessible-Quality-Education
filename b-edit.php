<?php
include_once 'dbConnection.php';  // Include the database connection class
include_once 'b-crud.php';  // Include the CRUD class

// Create a new database connection
$database = new databaseConn();
$db = $database->connect();

// Check if material_id is set
if (!isset($_GET['material_id']) || empty($_GET['material_id'])) {
    header("Location: upload.php?error=missing_id");
    exit;
}

$material_id = (int)$_GET['material_id'];  // Ensure material_id is an integer
$crud = new Crud($db);

// Validate form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = isset($_POST['title']) ? htmlspecialchars(trim($_POST['title'])) : null;
    $document = isset($_FILES['document']) && $_FILES['document']['error'] === UPLOAD_ERR_OK ? file_get_contents($_FILES['document']['tmp_name']) : null;

    if (empty($title)) {
        header("Location: edit.php?material_id=$material_id&error=missing_title");
        exit;
    }

    // Call the updateFile method
    if ($crud->updateFile($material_id, $title, $document)) {
        header("Location: upload.php?success=file_updated");
    } else {
        header("Location: edit.php?material_id=$material_id&error=update_failed");
    }
    exit;
}
?>
