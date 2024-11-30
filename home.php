<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header('Location: login.php');
    exit();
}

// Include database connection and CRUD class
require_once 'dbConnection.php';
require_once 'b-crud.php';

$database = new databaseConn();
$db = $database->connect();
$crud = new crud($db);

// Fetch uploaded files from the database
$files = $crud->readFile();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

    

    <script>
        $(document).ready(function() {
            $('#userTable').DataTable();
        });
    </script>
</head>

<body>
    <h1>Home</h1>
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <a href="upload.php"><button>Upload</button></a>
    <br><br>
    <table id="userTable" class="display">
        <thead>
            <tr>
                <th>Title</th>
                <th>Type</th>
                <th>Preview</th>
                <th>Contributor</th>
                <th>Upload Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($files as $file): ?>
                <tr>
                    <td><?php echo htmlspecialchars($file['title']); ?></td>
                    <td>
                        <?php 
                        $fileType = pathinfo($file['title'], PATHINFO_EXTENSION);
                        echo htmlspecialchars(strtoupper($fileType)); 
                        ?>
                    </td>
                    <td>
                    <a href="view_file.php?material_id=<?php echo $file['material_id']; ?>" target="_blank">View</a>
                    </td>
                    <td>
                        <?php
                        // Assuming you have a contributor field; otherwise, replace with a placeholder or remove
                        echo htmlspecialchars($file['contributor'] ?? 'Unknown');
                        ?>
                    </td>
                    <td>
                        <?php
                        // Assuming you have an upload_date field; otherwise, replace with a placeholder or remove
                        echo htmlspecialchars($file['upload_date'] ?? 'N/A');
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>
