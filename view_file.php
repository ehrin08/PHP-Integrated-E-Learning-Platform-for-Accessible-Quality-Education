<?php
session_start();
require_once 'dbConnection.php';
require_once 'b-crud.php';

if (isset($_GET['material_id'])) {
    $material_id = intval($_GET['material_id']);
    $database = new databaseConn();
    $conn = $database->connect();
    $crud = new Crud($conn);

    $file = $crud->getFile($material_id);

    if ($file) {
        header('Content-Type: application/pdf');
        header("Content-Disposition: inline; filename=\"" . $file['title'] . "\"");

        echo $file['document'];
    } else {
        echo "File not found.";
    }
} else {
    echo "No material ID specified.";
}
?>
