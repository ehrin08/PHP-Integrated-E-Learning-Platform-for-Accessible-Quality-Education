<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

require_once 'dbConnection.php';
require_once 'b-crud.php';

$database = new databaseConn();
$db = $database->connect();
$crud = new crud($db);

$username = $_SESSION['username'];
$accountId = $crud->getAccountIdByUsername($username);
$files = $crud->readAllFiles();
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

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <script>
        $(document).ready(function() {
            $('#userTable').DataTable();
        });
    </script>
</head>

<body>
    <nav>
        <a href="home.php">
            <h3>EmpowerEd</h3>
        </a>
    </nav>
    <div class="front">
        <h3 style="padding:20px">Home</h3>
        <h4>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h4>
        <a href="upload.php" class="btns-h">Upload</a>
        <a href="b-logout.php" class="btns-h">Logout</a>
        <div style="padding:20px">
            <div class="table">
                <table id="userTable" class="display">
                    <thead>
                        <tr>
                            <th>Title</th>
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
                                    <a href="ViewFile.php?material_id=<?php echo $file['material_id']; ?>" target="_blank">View</a>
                                </td>
                                <td>
                                    <?php
                                    
                                    echo htmlspecialchars($file['contributor'] ?? 'Unknown');
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    
                                    echo htmlspecialchars($file['upload_date'] ?? 'N/A');
                                    ?>
                                </td>
                            

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>


    </div>

</body>

</html>