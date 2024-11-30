<?php
require_once 'dbConnection.php';
require_once 'b-crud.php';
require_once 'sweetAlert.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new databaseConn();
    $db = $database->connect();

    $login = new crud($db);


    $login->email = htmlspecialchars(trim($_POST['email']));
    $login->password = htmlspecialchars(trim($_POST['password']));

    if ($login->login()) {
        header('location: home.php');
        exit;
    } else {
        echo sweetAlert('Oops...', 'Something went wrong!', 'error', 'login.php');
    }
}
