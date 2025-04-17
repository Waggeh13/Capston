<?php
session_start();
require_once("../controllers/doctor_lab_controller.php");

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'Doctor') {
    echo json_encode(["success" => false, "message" => "Unauthorized: You must be logged in as a doctor"]);
    exit;
}

$controller = new DoctorLabController();
$doctor_id = $_SESSION['user_id'];
$result = $controller->getDoctorLabRequests($doctor_id);

echo json_encode($result);
?>