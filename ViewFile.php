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

// Check if material_id is set and fetch file details
$title = "No Material Selected";
$contributor = "Unknown Contributor";
$upload_date = "Not Available";
$feedbacks = [];
if (isset($_GET['material_id'])) {
    $material_id = intval($_GET['material_id']);
    $file = $crud->getFile($material_id);
    if ($file) {
        $title = $file['title'] ?? $title;
        $contributor = $file['contributor'] ?? $contributor;
        $upload_date = $file['upload_date'] ?? $upload_date;

        // Fetch feedbacks for this material
        $feedbacks = $crud->getFeedbacks($material_id);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View File - <?php echo htmlspecialchars($title); ?></title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="script.js"></script>
</head>

<body>
    <nav>
        <a href="home.php">
            <h3>EmpowerEd</h3>
        </a>
    </nav>
    <div class="front">
        <table style="width: 100%; ">
            <tr>
                <td style="width: 50%; height: 85vh; vertical-align: top; padding:40px;">
                    <div class="left">
                        <h1><?php echo htmlspecialchars($title); ?></h1>
                        <p><strong>Contributor:</strong> <?php echo htmlspecialchars($contributor); ?></p>
                        <p><strong>Upload Date:</strong> <?php echo htmlspecialchars($upload_date); ?></p>
                    </div>

                    <!-- Feedback Form -->
                    <h3>Add Feedback</h3>
                    <br>
                    <form id="feedbackForm" onsubmit="submitFeedback(event)" style="width: 80%;">
                        <input type="hidden" name="material_id" value="<?php echo $material_id; ?>" />
                        <div class="form-group">
                            <textarea name="comment" class="form-control" rows="4" placeholder="Add your feedback here..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Feedback</button>
                    </form>
                    <br>
                    <h3>Feedbacks</h3>
                    <br>
                    <iframe src="feedback.php?material_id=<?php echo $material_id; ?>" width="100%" height="400px" style="border: none;"></iframe>

                </td>
                <td style="width: 50%; vertical-align: top;">
                    <?php if (isset($_GET['material_id'])): ?>
                        <iframe
                            src="b-viewFile.php?material_id=<?php echo $material_id; ?>"
                            width="100%"
                            height="800vh"
                            style="border: none;">
                        </iframe>
                    <?php else: ?>
                        <p>No material selected to view.</p>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>