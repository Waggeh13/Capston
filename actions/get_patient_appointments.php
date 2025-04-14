<?php
include("../controllers/appointment_controller.php");

session_start();
$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_id = isset($_SESSION['user_id']) ? sanitize_input($_SESSION['patient_id']) : '';
    
    if (empty($patient_id)) {
        $response["message"] = "Patient ID is missing.";
    } else {
        $appointment = new appointment_class();
        $appointments = $appointment->get_patient_appointments($patient_id);
        
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