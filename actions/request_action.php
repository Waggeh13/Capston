<?php
include("../controllers/request_controller.php");
session_start();
$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_id = isset($_SESSION['user_id']) ? sanitize_input($_SESSION['user_id']) : '';
    $doctor_id = isset($_POST['doctorId']) ? sanitize_input($_POST['doctorId']) : '';
    $hospitalName = isset($_POST['hospitalName']) ? sanitize_input($_POST['hospitalName']) : '';

    if (empty($patient_id)) {
        $response["message"] = "Patient not authenticated.";
    } elseif (empty($doctor_id)) {
        $response["message"] = "Doctor selection is required.";
    } elseif (empty($hospitalName)) {
        $response["message"] = "Hospital name is required.";
    } else {
        $result = request($patient_id, $doctor_id, $hospitalName);
        
        if ($result) {
            $response["success"] = true;
            $response["message"] = "Medical summary requested successfully.";
        } else {
            $response["message"] = "Error: Unable to request summary. Please try again.";
            error_log("Failed to submit medical report request for patient_id: $patient_id, doctor_id: $doctor_id");
        }
    }
} else {
    $response["message"] = "Invalid request method.";
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>