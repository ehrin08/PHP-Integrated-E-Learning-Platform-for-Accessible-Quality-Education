<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}


require_once 'b-crud.php';


$crud = new crud();

// Check if material_id is set and fetch feedbacks
$feedbacks = [];
if (isset($_GET['material_id'])) {
    $material_id = intval($_GET['material_id']);
    
    // Fetch feedbacks for this material
    $feedbacks = $crud->getFeedbacks($material_id);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    <div class="feedbacks">
    <?php if (count($feedbacks) > 0): ?>
        <?php foreach ($feedbacks as $feedback): ?>
            <div class="feedback">
                <p><strong><?php echo htmlspecialchars($feedback['contributors_name']); ?></strong> commented:</p>
                <p><?php echo htmlspecialchars($feedback['comment']); ?></p>
                <hr>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No feedback available for this material.</p>
    <?php endif; ?>
</div>
</body>
</html>

