<?php

$dbhostname = "localhost";
$dbname = "qualityeduc";
$dbusername = "root";
$dbpassword = "";


$conn = new mysqli($dbhostname, $dbusername, $dbpassword, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
