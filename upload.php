<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Document</title>
<<<<<<< Updated upstream
=======
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <script>
        $(document).ready(function() {
            $('#userTable').DataTable();
        });
    </script>
>>>>>>> Stashed changes
</head>

<body>
    <h1>Upload File</h1>
    <form action="b-upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="document" required>
        <br>
<<<<<<< Updated upstream
        <label for="title">Title: </label>
        <input type="text" name="title" id="title" required>
        <br><br>
        <button type="submit"> Submit</button>
    </form>
    <br>
    <a href="home.php">Home</a>
=======
        <h3 style="padding: 20px;">Uploaded Files by you</h3>
        <div style="padding:20px">
            <div class="table">
                <table id="userTable" class="display">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Preview</th>
                            <th>Contributor</th>
                            <th>Upload Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($files as $file): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($file['title']); ?></td>
                                <td>
                                    <a href="view_file.php?material_id=<?php echo $file['material_id']; ?>" target="_blank">View</a>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($file['contributor'] ?? 'Unknown'); ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($file['upload_date'] ?? 'N/A'); ?>
                                </td>
                                <td>
                                    <!-- Edit Icon -->
                                    <span>
                                        <a href="edit.php?id=1" title="Edit">
                                            <i class="fa fa-edit" style="color: #007bff; cursor: pointer;"></i>
                                        </a>
                                    </span>

                                    <!-- Delete Icon -->
                                    
                                    <span>
                                        <form method="POST" action="b-delete.php" style="display:inline;">
                                            <input type="hidden" name="material_id" value="<?php echo $file['material_id']; ?>" />
                                            <button type="submit" name="btndelete" style="border: none; background: transparent; padding: 0; cursor: pointer;">
                                                <i class="fa fa-trash" style="color: #dc3545; font-size: 20px;"></i>
                                            </button>
                                        </form>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
>>>>>>> Stashed changes

</body>

</html>