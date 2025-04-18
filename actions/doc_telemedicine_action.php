<?php
session_start();
include("../controllers/doc_telemedicine_controller.php");

$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = isset($_POST['action']) ? sanitize_input($_POST['action']) : '';

    if ($action === 'get_doctor_appointments') {
        $staff_id = isset($_SESSION['user_id']) ? sanitize_input($_SESSION['user_id']) : '';
        if (empty($staff_id)) {
            $response["message"] = "Doctor not authenticated.";
        } else {
            $appointments = doctor_gettelemedicineappointmentsController($staff_id);
            if ($appointments === false) {
                $response["message"] = "Error fetching appointments.";
            } elseif (empty($appointments)) {
                $response["message"] = "No virtual appointments found.";
            } else {
                $response["success"] = true;
                $response["appointments"] = $appointments;
            }
        }
    } elseif ($action === 'start_meeting') {
        $booking_id = isset($_POST['booking_id']) ? sanitize_input($_POST['booking_id']) : '';
        if (empty($booking_id)) {
            $response["message"] = "Booking ID is required.";
        } else {
            $meeting_details = doctor_getmeetingdetailsController($booking_id);
            if ($meeting_details === false) {
                $response["message"] = "Error fetching meeting details.";
            } elseif (!$meeting_details) {
                $response["message"] = "Meeting details not found or meeting is not scheduled.";
            } else {
                $response["success"] = true;
                $response["meeting"] = $meeting_details;
            }
        }
    } elseif ($action === 'save_notes') {
        $booking_id = isset($_POST['booking_id']) ? sanitize_input($_POST['booking_id']) : '';
        $notes = isset($_POST['notes']) ? sanitize_input($_POST['notes']) : '';
        if (empty($booking_id)) {
            $response["message"] = "Booking ID is required.";
        } elseif (empty($notes)) {
            $response["message"] = "Notes cannot be empty.";
        } else {
            $result = doctor_savenotesController($booking_id, $notes);
            if ($result) {
                $response["success"] = true;
                $response["message"] = "Notes saved successfully.";
            } else {
                $response["message"] = "Failed to save notes.";
            }
        }
    } elseif ($action === 'end_meeting') {
        $booking_id = isset($_POST['booking_id']) ? sanitize_input($_POST['booking_id']) : '';
        if (empty($booking_id)) {
            $response["message"] = "Booking ID is required.";
        } else {
            $result = doctor_endmeetingController($booking_id);
            if ($result) {
                $response["success"] = true;
                $response["message"] = "Meeting ended successfully.";
            } else {
                $response["message"] = "Failed to end meeting.";
            }
        }
    } else {
        $response["message"] = "Invalid action.";
    }
} else {
    $response["message"] = "Invalid request method.";
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>