<?php
// Start the session
session_start();

// Include the database connection file
include_once 'connection.php';  // Updated to 'connection.php'

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data and sanitize input
    $user = $conn->real_escape_string($_POST['username']);
    $pass = $conn->real_escape_string($_POST['password']);
    $category = $conn->real_escape_string($_POST['category']);

    // Validate category to avoid SQL injection
    $allowedCategories = ['student', 'contributor'];
    if (!in_array($category, $allowedCategories)) {
        die("Invalid category.");
    }

    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT * FROM $category WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $user, $pass);

    // Execute the statement
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any record matches
    if ($result->num_rows > 0) {
        // Set session variable for the username
        $_SESSION['username'] = $user;

        // Redirect to home.php outside the Commands folder
        header("Location: home.php");
        exit();
    } else {
        echo "Invalid username or password.";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
