<?php

require_once 'b-crud.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header('Content-Type: application/json');
    try {
        // Instantiate CRUD class (inherits database connection)
        $signUp = new crud();

        // Sanitize and assign input values
        $signUp->username = htmlspecialchars(trim($_POST['username']));
        $signUp->email = htmlspecialchars(trim($_POST['email']));
        $signUp->password = htmlspecialchars(trim($_POST['password']));

        // Attempt to sign up
        if ($signUp->signUp()) {
            echo json_encode(['status' => 'success', 'message' => 'Account created successfully!', 'redirect' => 'login.php']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Something went wrong!']);
        }
    } catch (PDOException $e) {
        // Custom error handling based on the exception
        $message = strpos($e->getMessage(), 'username') !== false
            ? 'Username already exists!'
            : (strpos($e->getMessage(), 'email') !== false
                ? 'Email already exists!'
                : 'An unexpected error occurred.');
        echo json_encode(['status' => 'error', 'message' => $message]);
    }
}
