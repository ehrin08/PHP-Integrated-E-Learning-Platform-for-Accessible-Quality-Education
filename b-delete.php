<?php
session_start();

require_once 'b-crud.php';



$crud = new crud();

// Check if the material_id is passed via GET and it's set
if (isset($_GET['material_id'])) {
    $material_id = $_GET['material_id'];
    $deleteRecord = new crud();;
    //$deleteRecord->id = $material_id;

    // Check if the deletion is successful
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
