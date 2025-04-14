<?php
session_start();
include("../controllers/patient_appointment_controller.php");

$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $patient_id = isset($_SESSION['user_id']) ? sanitize_input($_SESSION['user_id']) : '';
    
    if (empty($patient_id)) {
        $response["message"] = "Patient not logged in.";
    } else {
        $appointments = patient_getappointmentsController($patient_id);
        
        if ($appointments !== false) {
            $response["success"] = true;
            $response["appointments"] = $appointments;
        } else {
            $response["message"] = "No appointments found.";
        }
    }
} else {
    $response["message"] = "Invalid request method.";
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>