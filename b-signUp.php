<?php
require_once 'dbConnection.php';
require_once 'b-crud.php';
require_once 'sweetAlert.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $database = new databaseConn();
        $db = $database->connect();

        $signUp = new crud($db);
        $signUp->username = htmlspecialchars(trim($_POST['username']));
        $signUp->email = htmlspecialchars(trim($_POST['email']));
        $signUp->password = htmlspecialchars(trim($_POST['password']));

        if ($signUp->signUp()) {
            echo sweetAlert('Success!', 'Data was successfully inserted!', 'success', 'login.php');
        } else {
            echo sweetAlert('Oops...', 'Something went wrong!', 'error');
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // MySQL constraint violation
            // Check which field caused the error
            if (strpos($e->getMessage(), 'username') !== false) {
                echo sweetAlert('Error', 'Username already exists! Please choose a different one.', 'warning', 'signUp.php');
            } elseif (strpos($e->getMessage(), 'email') !== false) {
                echo sweetAlert('Error', 'Email already exists! Please use a different one.', 'warning', 'signUp.php');
            } else {
                echo sweetAlert('Error', 'A unique constraint was violated.', 'error', 'signUp.php');
            }
        } else {
            echo sweetAlert('Error', 'An unexpected error occurred: ' . $e->getMessage(), 'error');
        }
    }
}
?>
