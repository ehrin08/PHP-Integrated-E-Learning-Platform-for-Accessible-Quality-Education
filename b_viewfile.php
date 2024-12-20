<?php
session_start();

require_once 'b_crud.php';

$crud = new crud();
if (isset($_GET['material_id'])) {
    $material_id = intval($_GET['material_id']);


    $file = $crud->getFile($material_id);

    if ($file) {
        header('Content-Type: application/pdf');
        header("Content-Disposition: inline; filename=\"" . $file['title'] . "\"");

        echo $file['document'];
    } else {
        echo "File not found.";
    }
} else {
    echo "No material ID specified.";
}
