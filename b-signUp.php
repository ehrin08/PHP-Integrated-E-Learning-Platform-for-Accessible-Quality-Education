<?php
require_once 'dbConnection.php';
require_once 'b-crud.php';

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
            echo json_encode(['status' => 'success', 'message' => 'Data was successfully inserted!', 'redirect' => 'login.php']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Something went wrong!']);
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            if (strpos($e->getMessage(), 'username') !== false) {
                echo json_encode(['status' => 'warning', 'message' => 'Username already exists! Please choose a different one.']);
            } elseif (strpos($e->getMessage(), 'email') !== false) {
                echo json_encode(['status' => 'warning', 'message' => 'Email already exists! Please use a different one.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'A unique constraint was violated.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred: ' . $e->getMessage()]);
        }
    }
}
