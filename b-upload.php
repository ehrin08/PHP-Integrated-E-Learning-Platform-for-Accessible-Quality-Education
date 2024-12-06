<?php
session_start();
require_once 'dbConnection.php';
require_once 'b-crud.php';

header('Content-Type: application/json'); // Set JSON response header

$database = new databaseConn();
$conn = $database->connect();

$crud = new Crud($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['document'])) {
    $title = $_POST['title'];
    $fileName = $_FILES['document']['name'];
    $fileData = file_get_contents($_FILES['document']['tmp_name']);
    $uploader = $_SESSION['username']; // Get the uploader's username

    // Retrieve account_id using the method in the crud class
    $accountId = $crud->getAccountIdByUsername($uploader);

    if ($accountId && $crud->uploadFile($title, $fileData, $uploader, $accountId)) {
        echo json_encode([
            'status' => 'success',
            'message' => 'File uploaded successfully!',
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'File upload failed.',
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'No file uploaded or invalid request.',
    ]);
}
?>
