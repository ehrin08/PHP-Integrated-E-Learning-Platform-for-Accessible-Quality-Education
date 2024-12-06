<?php
session_start();
require_once 'dbConnection.php';
require_once 'b-crud.php';

$database = new databaseConn();
$conn = $database->connect();

$crud = new Crud($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btndelete'])) {
    $material_id = $_POST['material_id'];
    $deleteRecord = new crud($conn);
    $deleteRecord->id = $material_id;

    if ($deleteRecord->deleteFile($material_id)) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Record and file were successfully deleted!',
            'redirect' => 'upload.php'  // Optional redirect after delete
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to delete the record!'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'No material ID provided!',
    ]);
}
?>
