<?php
include("../controllers/appointment_controller.php");

$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_id = sanitize_input($_POST['booking_id']);
    
    $result = deleteappointmentController($booking_id);
    
    if ($result) {
        $response["success"] = true;
        $response["message"] = "Appointment deleted successfully.";
    } else {
        $response["success"] = false;
        $response["message"] = "Error: Unable to delete appointment.";
    }
} else {
    $response["message"] = "Invalid request method.";
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>