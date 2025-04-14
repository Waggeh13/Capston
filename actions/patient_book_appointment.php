<?php
session_start();
include("../controllers/patient_appointment_controller.php");

$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_id = isset($_SESSION['user_id']) ? sanitize_input($_SESSION['user_id']) : '';
    $staff_id = sanitize_input($_POST['staff_id']);
    $appointmentDate = sanitize_input($_POST['appointmentDate']);
    $appointmentTime = sanitize_input($_POST['appointmentTime']);
    $appointmentType = sanitize_input($_POST['appointmentType']);
    $clinic_id = sanitize_input($_POST['clinic_id']);
    $timeslot_id = sanitize_input($_POST['timeslot_id']);

    if (empty($patient_id)) {
        $response["message"] = "Patient not logged in.";
    } elseif (empty($staff_id) || empty($appointmentDate) || empty($appointmentTime) || empty($appointmentType) || empty($clinic_id) || empty($timeslot_id)) {
        $response["message"] = "All fields are required.";
    } else {
        $result = patient_bookappointmentController($patient_id, $staff_id, $appointmentDate, $appointmentTime, $appointmentType, $clinic_id, $timeslot_id);
        
        if ($result) {
            $response["success"] = true;
            $response["message"] = "Appointment booked successfully.";
        } else {
            $response["message"] = "Error: Unable to book appointment. Please try again.";
        }
    }
} else {
    $response["message"] = "Invalid request method.";
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>