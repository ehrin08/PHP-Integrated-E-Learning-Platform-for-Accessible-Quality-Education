<?php
// Start the session
session_start();

// Check if the session variable 'username' is set
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Fetch the username from the session
$username = htmlspecialchars($_SESSION['username']); // Escape for security

// Include the database connection file
include_once 'connection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $fileType = $_POST['fileType'];
    $file = $_FILES['document'];

    // Validate file
    if ($file['error'] === UPLOAD_ERR_OK) {
        // Get file content
        $fileContent = file_get_contents($file['tmp_name']);
        
        // Escape the content for security
        $fileContent = $conn->real_escape_string($fileContent);

        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO learning_materials (type, document, contributor) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $fileType, $fileContent, $username);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to home.php with success message
            header("Location: home.php?status=success");
            exit();
        } else {
            // Redirect to home.php with error message
            header("Location: home.php?status=error");
            exit();
        }

        // Close the statement
        $stmt->close();
    } else {
        // Redirect to home.php with file upload error
        header("Location: home.php?status=file_error");
        exit();
    }

    // Close the connection
    $conn->close();
}
?>
