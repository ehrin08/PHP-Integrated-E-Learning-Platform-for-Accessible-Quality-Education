<?php
session_start();
include_once 'connection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username']; 
    $score = $_POST['score']; 

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