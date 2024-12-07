<?php
  // Include the database connection class
require_once 'b_crud.php';  // Include the CRUD class

header('Content-Type: application/json'); // Set the response header to JSON

// Create a new database connection

$crud = new crud();

// Validate material_id
if (!isset($_GET['material_id']) || empty($_GET['material_id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Missing material ID.'
    ]);
    exit;
}

$material_id = (int)$_GET['material_id']; // Ensure material_id is an integer

// Check if file exists
$file = $crud->getFile($material_id);
if (!$file) {
    echo json_encode([
        'status' => 'error',
        'message' => 'File not found.'
    ]);
    exit;
}

// Handle the POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'] ?? ''; // Get the new title
    $fileData = null;

    // Check if a new file is uploaded
    if (isset($_FILES['document']) && is_uploaded_file($_FILES['document']['tmp_name'])) {
        $fileData = file_get_contents($_FILES['document']['tmp_name']);
    }

    // Update the file using CRUD method
    $updateResult = $crud->updateFile($material_id, $title, $fileData);

    if ($updateResult) {
        echo json_encode([
            'status' => 'success',
            'message' => 'File updated successfully!',
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to update the file.',
        ]);
    }
    exit;
}

// If not a POST request, return an error
echo json_encode([
    'status' => 'error',
    'message' => 'Invalid request method.'
]);
exit;
?>
