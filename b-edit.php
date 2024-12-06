<?php
include_once 'dbConnection.php';  
include_once 'b-crud.php'; 
include_once 'sweetAlert.php';  

header('Content-Type: application/json'); 

$database = new databaseConn();
$db = $database->connect();
$crud = new Crud($db);

if (!isset($_GET['material_id']) || empty($_GET['material_id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Missing material ID.'
    ]);
    exit;
}

$material_id = (int)$_GET['material_id'];

$file = $crud->getFile($material_id);
if (!$file) {
    echo json_encode([
        'status' => 'error',
        'message' => 'File not found.'
    ]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'] ?? '';
    $fileData = null;

    if (isset($_FILES['document']) && is_uploaded_file($_FILES['document']['tmp_name'])) {
        $fileData = file_get_contents($_FILES['document']['tmp_name']);
    }

    $updateResult = $crud->updateFile($material_id, $title, $fileData);

    if ($updateResult) {
        echo json_encode([
            'status' => 'success',
            'message' => 'File updated successfully!',
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to update the file.',
        ]);
    }
    exit;
}

echo json_encode([
    'status' => 'error',
    'message' => 'Invalid request method.'
]);
exit;
?>