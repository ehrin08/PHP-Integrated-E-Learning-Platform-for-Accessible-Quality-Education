<?php
session_start();
include_once 'connection.php';

class User {
    private $username;

    public function __construct() {
        if (!isset($_SESSION['username'])) {
            header("Location: login.php");
            exit();
        }
        $this->username = htmlspecialchars($_SESSION['username']);
    }

    public function getUsername() {
        return $this->username;
    }
}

class FileUploadStatus {
    private $status;

    public function __construct() {
        $this->status = isset($_GET['status']) ? $_GET['status'] : '';
    }

    public function showAlert() {
        if ($this->status == 'success') {
            echo "<script>alert('File uploaded successfully!');</script>";
        } elseif ($this->status == 'error') {
            echo "<script>alert('Error uploading file. Please try again.');</script>";
        } elseif ($this->status == 'file_error') {
            echo "<script>alert('There was an error with the file upload.');</script>";
        } elseif ($this->status == 'deleted') {
            echo "<script>alert('File deleted successfully!');</script>";
        }
    }
}

$user = new User();
$fileStatus = new FileUploadStatus();

$sql = "SELECT material_id, type, title, contributor, upload_date FROM learning_materials ORDER BY upload_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <h1>Welcome <?php echo $user->getUsername(); ?></h1>

    <!-- Logout Button -->
    <form action="logout.php" method="post">
        <button type="submit">Logout</button>
    </form>

    <?php $fileStatus->showAlert(); ?>

    <h3>Contribute:</h3>
    <form action="contribute.php" method="post" enctype="multipart/form-data">
        <label for="fileType">Type of file:</label>
        <select name="fileType" id="fileType">
            <option value="pdf">PDF</option>
            <option value="video">Video</option>
            <option value="picture">Picture</option>
        </select>
        <input type="file" name="document" required>
        <br>
        <label for="title">Title: </label>
        <input type="text" name="title" id="title" required>
        <br><br>
        <button type="submit">Submit</button>
    </form>

    <h3>Contributions:</h3>
    <?php if ($result->num_rows > 0): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Material ID</th>
                    <th>Type</th>
                    <th>Title</th>
                    <th>Contributor</th>
                    <th>Upload Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['material_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['type']); ?></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo htmlspecialchars($row['contributor']); ?></td>
                        <td><?php echo htmlspecialchars($row['upload_date']); ?></td>
                        <td>
                            <form action="contribute.php" method="post" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                <input type="hidden" name="delete_material_id" value="<?php echo htmlspecialchars($row['material_id']); ?>">
                                <button type="submit" name="delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No contributions yet.</p>
    <?php endif; ?>

</body>
</html>

<?php
$conn->close();
?>
