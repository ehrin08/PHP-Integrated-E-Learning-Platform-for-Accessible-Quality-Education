<?php
session_start();
include_once 'connection.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username']; // Assuming username is stored in session
    $score = $_POST['score']; // Get the score from the quiz form

    $stmt = $conn->prepare("INSERT INTO quiz_scores (username, score) VALUES (?, ?)");
    $stmt->bind_param("si", $username, $score);

    if ($stmt->execute()) {
        echo "Score submitted successfully!";
    } else {
        echo "Error submitting score.";
    }

    $stmt->close();
}
$conn->close();
?>