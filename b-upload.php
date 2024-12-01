<?php
session_start();
require_once 'dbConnection.php';
require_once 'b-crud.php';
require_once 'sweetAlert.php';

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
        echo sweetAlert('Success', 'File uploaded successfully!', 'success', 'upload.php');
    } else {
        echo sweetAlert('Error', 'File upload failed.', 'error', 'upload.php');
    }
}
