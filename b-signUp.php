<?php
require_once 'dbConnection.php';
require_once 'b-crud.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header('Content-Type: application/json');
    try {
        $database = new databaseConn();
        $db = $database->connect();

        $signUp = new crud($db);
        $signUp->username = htmlspecialchars(trim($_POST['username']));
        $signUp->email = htmlspecialchars(trim($_POST['email']));
        $signUp->password = htmlspecialchars(trim($_POST['password']));

        if ($signUp->signUp()) {
            echo json_encode(['status' => 'success', 'message' => 'Account created successfully!', 'redirect' => 'login.php']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Something went wrong!']);
        }
    } catch (PDOException $e) {
        $message = strpos($e->getMessage(), 'username') !== false ? 'Username already exists!' :
                   (strpos($e->getMessage(), 'email') !== false ? 'Email already exists!' : 'An unexpected error occurred.');
        echo json_encode(['status' => 'error', 'message' => $message]);
    }
}
