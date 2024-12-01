<?php
session_start();
require_once 'dbConnection.php';
require_once 'b-crud.php';

$database = new databaseConn();
$conn = $database->connect();

$crud = new Crud($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['document'])) {
    $title = $_POST['title'];
    $fileName = $_FILES['document']['name'];
    $fileData = file_get_contents($_FILES['document']['tmp_name']);
    $uploader = $_SESSION['username']; // Get the uploader's username

    if ($crud->uploadFile($title, $fileData, $uploader)) {
        echo "<script>alert('File uploaded successfully!'); window.location = 'upload.php';</script>";
    } else {
        echo "<script>alert('File upload failed.'); window.location = 'upload.php';</script>";
    }
}
?>