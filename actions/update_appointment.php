<?php
include("../controllers/appointment_controller.php");

$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_id = sanitize_input($_POST['booking_id']);
    $patientName = sanitize_input($_POST['patientName']);
    $staff_id = sanitize_input($_POST['staff_id']);
    $appointmentDate = sanitize_input($_POST['appointmentDate']);
    $appointmentTime = sanitize_input($_POST['appointmentTime']);
    $appointmentType = sanitize_input($_POST['appointmentType']);
    $clinic_id = sanitize_input($_POST['clinic_id']);
    $timeslot_id = sanitize_input($_POST['timeslot_id']);

    $result = updateappointmentController($booking_id, $patientName, $staff_id, $appointmentDate, $appointmentTime, $appointmentType, $clinic_id, $timeslot_id);
    
    if ($result) {
        $response["success"] = true;
        $response["message"] = "Appointment updated successfully.";
    } else {
        $response["success"] = false;
        $response["message"] = "Error: Unable to update appointment. Please try again.";
    }
} else {
    $response["message"] = "Invalid request method.";
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>