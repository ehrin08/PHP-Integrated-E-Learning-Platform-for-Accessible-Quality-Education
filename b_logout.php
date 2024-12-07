<?php
session_start(); // Starts the session to access session variables
session_unset(); // Unsets all session variables
session_destroy(); // Destroys the session

// Redirects to the index.php page in the root directory
header("Location: index.php");
exit();
?>
