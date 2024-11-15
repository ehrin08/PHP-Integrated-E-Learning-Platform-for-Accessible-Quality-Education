<?php
// Start the session
session_start();

// Check if the session variable 'username' is set
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location:   login.php");
    exit();
}

// Fetch the username from the session
$username = htmlspecialchars($_SESSION['username']); // Escape for security

// Include the database connection file (if necessary for future use)
include_once 'connection.php';

// Check for status in the URL query parameter
$status = isset($_GET['status']) ? $_GET['status'] : '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <h1>Welcome <?php echo $username; ?></h1>

    <?php
    // Display status message
    if ($status == 'success') {
        echo "<script>alert('File uploaded successfully!');</script>";
    } elseif ($status == 'error') {
        echo "<script>alert('Error uploading file. Please try again.');</script>";
    } elseif ($status == 'file_error') {
        echo "<script>alert('There was an error with the file upload.');</script>";
    }
    ?>

    <h3>Contribute:</h3>
    <form action="contribute.php" method="post" enctype="multipart/form-data">
        <label for="fileType">Type of file:</label>
        <select name="fileType" id="fileType">
            <option value="pdf">PDF</option>
            <option value="video">Video</option>
            <option value="picture">Picture</option>
        </select>
        <input type="file" name="document" required>
        <br><br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
