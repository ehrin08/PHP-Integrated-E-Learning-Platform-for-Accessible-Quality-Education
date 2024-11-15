<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = htmlspecialchars($_SESSION['username']);

include_once 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fileType = $_POST['fileType'];
    $file = $_FILES['document'];

    if ($file['error'] === UPLOAD_ERR_OK) {
        $fileContent = file_get_contents($file['tmp_name']);
        $fileContent = $conn->real_escape_string($fileContent);

        $stmt = $conn->prepare("INSERT INTO learning_materials (type, document, contributor) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $fileType, $fileContent, $username);

        if ($stmt->execute()) {
            header("Location: home.php?status=success");
            exit();
        } else {
            header("Location: home.php?status=error");
            exit();
        }

        $stmt->close();
    } else {
        header("Location: home.php?status=file_error");
        exit();
    }

    $conn->close();
}
?>
