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
    
    // Retrieve account_id based on session username
    $query = "SELECT account_id FROM account WHERE username = :username";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':username', $uploader);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $accountId = $user['account_id'];

    if ($crud->uploadFile($title, $fileData, $uploader, $accountId)) {
        echo sweetAlert('Success', 'File uploaded successfully!', 'success', 'upload.php');
    } else {
        echo sweetAlert('Error', 'File upload failed.', 'error', 'upload.php');
    }
}

?>
