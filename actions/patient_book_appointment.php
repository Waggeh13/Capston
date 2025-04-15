<?php
session_start();
require_once("../controllers/patient_appointment_controller.php");
require_once("../classes/patient_appointment_class.php");

header('Content-Type: application/json');
$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_id = isset($_SESSION['user_id']) ? sanitize_input($_SESSION['user_id']) : '';
    $staff_id = isset($_POST['staff_id']) ? sanitize_input($_POST['staff_id']) : '';
    $appointmentDate = isset($_POST['appointmentDate']) ? sanitize_input($_POST['appointmentDate']) : '';
    $appointmentTime = isset($_POST['appointmentTime']) ? sanitize_input($_POST['appointmentTime']) : '';
    $appointmentType = isset($_POST['appointmentType']) ? sanitize_input($_POST['appointmentType']) : '';
    $clinic_id = isset($_POST['clinic_id']) ? sanitize_input($_POST['clinic_id']) : '';
    $timeslot_id = isset($_POST['timeslot_id']) ? sanitize_input($_POST['timeslot_id']) : '';

    error_log("Booking attempt: patient_id=$patient_id, staff_id=$staff_id, date=$appointmentDate, time=$appointmentTime, type=$appointmentType, clinic_id=$clinic_id, timeslot_id=$timeslot_id");

    if (empty($patient_id)) {
        $response["message"] = "Patient not logged in.";
    } elseif (empty($staff_id) || empty($appointmentDate) || empty($appointmentTime) || empty($appointmentType) || empty($clinic_id) || empty($timeslot_id)) {
        $missing = [];
        if (empty($staff_id)) $missing[] = "staff_id";
        if (empty($appointmentDate)) $missing[] = "appointmentDate";
        if (empty($appointmentTime)) $missing[] = "appointmentTime";
        if (empty($appointmentType)) $missing[] = "appointmentType";
        if (empty($clinic_id)) $missing[] = "clinic_id";
        if (empty($timeslot_id)) $missing[] = "timeslot_id";
        $response["message"] = "Missing required fields: " . implode(", ", $missing);
    } else {
        try {
            $appointment = new patient_appointment_class();
            if ($appointmentType === 'virtual') {
                $token_status = $appointment->checkZoomToken();
                if (!$token_status['has_token']) {
                    $oauth_url = $appointment->initiateZoomOAuth();
                    $response["success"] = false;
                    $response["message"] = "Zoom authorization required. Please authorize Zoom to proceed.";
                    $response["redirect"] = $oauth_url;
                    echo json_encode($response);
                    exit();
                }
            }
            $result = patient_bookappointmentController($patient_id, $staff_id, $appointmentDate, $appointmentTime, $appointmentType, $clinic_id, $timeslot_id);
            if ($result['success']) {
                $response["success"] = true;
                $response["message"] = "Appointment booked successfully.";
            } else {
                $response["message"] = $result['message'] ?: "Failed to book appointment: Unknown error.";
            }
        } catch (Exception $e) {
            error_log("Booking error: " . $e->getMessage());
            $response["message"] = "Server error: " . $e->getMessage();
        }
    }
} else {
    $response["message"] = "Invalid request method.";
}

echo json_encode($response);
exit();
?>