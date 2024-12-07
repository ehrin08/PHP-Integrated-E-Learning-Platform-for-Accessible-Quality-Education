<?php
session_start(); // Start session to access $_SESSION data

require_once 'b-crud.php';

header('Content-Type: application/json'); // Set JSON response header

// Create a database connection

$crud = new crud();

// Check if the request method is POST and feedback data is present
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $material_id = isset($_POST['material_id']) ? intval($_POST['material_id']) : null;
    $comment = isset($_POST['comment']) ? htmlspecialchars(trim($_POST['comment'])) : null;
    $contributor_name = isset($_SESSION['username']) ? $_SESSION['username'] : null;

    // Check if required fields are provided
    if ($material_id && $comment && $contributor_name) {
        // Add feedback to the database
        $result = $crud->addFeedback($material_id, $comment, $contributor_name);

        if ($result) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Feedback added successfully!',
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to add feedback.',
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Missing required data.',
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method or missing data.',
    ]);
}
?>
