<?php

require_once 'b_crud.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        

        $login = new crud();

        $login->email = htmlspecialchars(trim($_POST['email']));
        $login->password = htmlspecialchars(trim($_POST['password']));

        if ($login->login()) {
            echo json_encode(['status' => 'success', 'message' => 'Login successful!', 'redirect' => 'home.php']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid email or password.']);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
    }
}
