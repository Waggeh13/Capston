<?php
include("../controllers/appointment_controller.php");

$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_id = sanitize_input($_POST['booking_id']);
    $status = sanitize_input($_POST['status']);
    
    $result = updateappointmentstatusController($booking_id, $status);
    
    if ($result) {
        $response["success"] = true;
        $response["message"] = "Status updated successfully.";
    } else {
        $response["success"] = false;
        $response["message"] = "Error updating status.";
    }
} else {
    $response["message"] = "Invalid request method.";
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>