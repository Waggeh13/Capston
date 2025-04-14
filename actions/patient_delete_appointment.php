<?php
include("../controllers/patient_appointment_controller.php");

$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_id = sanitize_input($_POST['booking_id']);
    
    if (empty($booking_id)) {
        $response["message"] = "Booking ID is required.";
    } else {
        $result = patient_deleteappointmentController($booking_id);
        
        if ($result) {
            $response["success"] = true;
            $response["message"] = "Appointment cancelled successfully.";
        } else {
            $response["message"] = "Error: Unable to cancel appointment.";
        }
    }
} else {
    $response["message"] = "Invalid request method.";
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>