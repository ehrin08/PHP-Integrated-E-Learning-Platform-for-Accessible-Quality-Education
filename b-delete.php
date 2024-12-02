<?php
session_start();
require_once 'dbConnection.php';
require_once 'b-crud.php';
require_once 'sweetAlert.php';

$database = new databaseConn();
$conn = $database->connect();

$crud = new Crud($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btndelete'])) {
    // Sanitize and retrieve the material_id from the POST request
    $material_id = $_POST['material_id'];


    // No need to create a new connection here, use the already established one
    $deleteRecord = new crud($conn);
    $deleteRecord->id = $material_id; // Use the correct variable for material_id

    // Delete the record from the database
    if ($deleteRecord->deleteFile($material_id)) {
        echo sweetAlert('Success!', 'Record and file were successfully deleted!', 'success', 'home.php');
    } else {
        echo sweetAlert('Oops...', 'Failed to delete the record!', 'error');
    }
}
?>
