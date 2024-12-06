<?php
include_once 'dbConnection.php'; 
include_once 'b-crud.php';  

$database = new databaseConn();
$db = $database->connect();

if (!isset($_GET['material_id']) || empty($_GET['material_id'])) {
    header("Location: upload.php?error=missing_id");
    exit;
}

$material_id = (int)$_GET['material_id'];  
$crud = new Crud($db);

$file = $crud->getFile($material_id);

if (!$file) {
    header("Location: upload.php?error=file_not_found");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Uploaded File</title>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="script.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body>
    <nav>
        <a href="home.php">
            <h3>EmpowerEd</h3>
        </a>
    </nav>
    <div class="container">
        <h3 class="text-center mt-5 mb-1">Edit Uploaded File</h3>
        <p class="text-center mt-1 mb-4">Click update after changing any information.</p>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form id="editForm" onsubmit="handleEditFile(event, <?php echo $material_id; ?>)" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" class="form-control"
                    value="<?php echo htmlspecialchars($file['title']); ?>" required>
            </div>
            <div class="form-group">
                <label for="current_file">Current File:</label>
                <p><a href="b-viewFile.php?material_id=<?php echo $material_id; ?>" target="_blank">
                        View Current File</a></p>
            </div>
            <div class="form-group">
                <label for="document">Replace File (optional):</label>
                <input type="file" name="document" id="document" class="form-control" accept=".pdf">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Update</button>
                <a href="upload.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>

</html>