<?php
// Database configuration
$dbhostname = "localhost";
$dbname = "qualityeduc";
$dbusername = "root";
$dbpassword = "";

// Create a database connection
$conn = new mysqli($dbhostname, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
