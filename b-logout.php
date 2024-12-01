<?php
session_start();

// Destroy the session to log out the user
session_unset();
session_destroy();

// Redirect to the index page (or login page)
header("Location: index.php");
exit();
?>
