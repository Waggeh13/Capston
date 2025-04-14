<?php
include("../controllers/appointment_controller.php");

$response = array("success" => false, "message" => "");

$appointments = getappointmentsController();

if ($appointments !== false) {
    $response["success"] = true;
    $response["appointments"] = $appointments;
} else {
    $response["message"] = "No appointments found.";
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>