<?php
session_start();

include_once 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $conn->real_escape_string($_POST['username']);
    $pass = $conn->real_escape_string($_POST['password']);
    $category = $conn->real_escape_string($_POST['category']);

    $allowedCategories = ['student', 'contributor'];
    if (!in_array($category, $allowedCategories)) {
        die("Invalid category.");
    }

    $stmt = $conn->prepare("SELECT * FROM $category WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $user, $pass);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $user;
        header("Location: home.php");
        exit();
    } else {
        echo "Invalid username or password.";
    }

    $stmt->close();
    $conn->close();
}
?>
