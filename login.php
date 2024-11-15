<?php
// Start the session
session_start();

// Database configuration
$hostname = "localhost";
$dbname = "qualityeduc";
$username = "root";
$password = "";

// Create a database connection
$conn = new mysqli($hostname, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

        // Redirect to home.php
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
