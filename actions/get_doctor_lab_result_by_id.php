<?php
session_start();
require_once("../controllers/doctor_lab_controller.php");

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'Doctor') {
    echo json_encode(["success" => false, "message" => "Unauthorized: You must be logged in as a doctor"]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
    exit;
}

$lab_id = isset($_POST['lab_id']) ? $_POST['lab_id'] : null;
if (!$lab_id) {
    echo json_encode(["success" => false, "message" => "Lab ID is required"]);
    exit;
}

$controller = new DoctorLabController();
$doctor_id = $_SESSION['user_id'];
$result = $controller->getDoctorLabResultById($lab_id, $doctor_id);

echo json_encode($result);
?>