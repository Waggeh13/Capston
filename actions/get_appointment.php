<?php
include("../controllers/appointment_controller.php");

$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_id = sanitize_input($_POST['booking_id']);
    
    if (empty($booking_id)) {
        $response["message"] = "Booking ID is required.";
    } else {
        $appointment = getappointmentController($booking_id);
        
        if ($appointment) {
            // Normalize appointment_type for frontend
            $appointment['appointment_type'] = strtolower($appointment['appointment_type']) === 'in-person' ? 'inPerson' : 'virtual';
            $response["success"] = true;
            $response["appointment"] = $appointment;
        } else {
            $response["message"] = "Appointment not found.";
        }
    }
} else {
    $response["message"] = "Invalid request method.";
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>