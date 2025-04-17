<?php
require_once("../controllers/lab_controller.php");

$controller = new LabController();
$result = $controller->getPendingLabRequests();

header('Content-Type: application/json');
echo json_encode($result);
?>