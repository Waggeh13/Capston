<?php
require_once("../controllers/lab_controller.php");

if (isset($_POST['lab_id'])) {
    $lab_id = $_POST['lab_id'];
    $controller = new LabController();
    $result = $controller->getLabRequestById($lab_id);

    header('Content-Type: application/json');
    echo json_encode($result);
} else {
    echo json_encode(["success" => false, "message" => "Lab ID not provided"]);
}
?>