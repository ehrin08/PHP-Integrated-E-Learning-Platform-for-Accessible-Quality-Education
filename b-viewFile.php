<?php
session_start();
require_once 'dbConnection.php';
require_once 'b-crud.php';
$database = new databaseConn();
    $conn = $database->connect();
    $crud = new Crud($conn);
if (isset($_GET['material_id'])) {
    $material_id = intval($_GET['material_id']);
    

    // Fetch the file from the database
    $file = $crud->getFile($material_id);

    if ($file) {
        // Set the appropriate headers for PDF
        header('Content-Type: application/pdf');
        header("Content-Disposition: inline; filename=\"" . $file['title'] . "\"");

        // Output the PDF content from the database
        echo $file['document'];
    } else {
        echo "File not found.";
    }
} else {
    echo "No material ID specified.";
}
?>