<?php
require_once 'dbConnection.php';
require_once 'b-crud.php';
require_once 'sweetAlert.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
}
?>
