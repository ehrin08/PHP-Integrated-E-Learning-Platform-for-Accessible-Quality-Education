<?php
require_once 'dbConnection.php';
require_once 'b-crud.php';

// Establish database connection
$database = new databaseConn();
$db = $database->connect();
$crud = new crud($db);

// Check if a material_id is provided in the query string
if (isset($_GET['material_id'])) {
    $material_id = intval($_GET['material_id']); // Ensure material_id is an integer

    // Fetch the file data using the crud class
    $file = $crud->getFile($material_id);

    if ($file) {
        // Serve the file as a PDF document
        header("Content-Type: application/pdf");
        header("Content-Disposition: inline; filename=\"" . $file['name'] . "\"");
        echo $file['document'];
        exit();
    } else {
        echo "File not found.";
    }
} else {
    echo "No material ID specified.";
}
?>
