<?php
session_start();
require_once 'dbConnection.php';
require_once 'b-crud.php';
require_once 'sweetAlert.php';

header('Content-Type: application/json'); // Set the response type to JSON

$database = new databaseConn();
$conn = $database->connect();
$crud = new Crud($conn);

// Check if the request method is POST and the document is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['document'])) {
    $title = $_POST['title']; // Get the title from the form
    $fileName = $_FILES['document']['name']; // Get the file name
    $fileData = file_get_contents($_FILES['document']['tmp_name']); // Get the file data
    $uploader = $_SESSION['username']; // Get the uploader's username

    // Get account ID by username
    $accountId = $crud->getAccountIdByUsername($uploader);

    // Check if account ID exists and upload the file
    if ($accountId && $crud->uploadFile($title, $fileData, $uploader, $accountId)) {
        echo json_encode([
            'status' => 'success',
            'message' => 'File uploaded successfully!',
            'redirect' => 'upload.php' // Redirect after upload
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'File upload failed.' // Error message
        ]);
    }
}
?>
