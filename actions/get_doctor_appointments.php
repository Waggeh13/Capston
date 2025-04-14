<?php
include("../controllers/appointment_controller.php");

session_start();
$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = isset($_POST['date']) ? sanitize_input($_POST['date']) : '';
    $staff_id = isset($_SESSION['user_id']) ? sanitize_input($_SESSION['user_id']) : '';
    
    if (empty($date) || empty($staff_id)) {
        $response["message"] = "Date or staff ID is missing.";
    } else {
        $appointments = getdoctorappointmentsController($staff_id, $date);
        
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