<?php
include("../controllers/doc_schedule_controller.php");

session_start(); // Assuming staff_id comes from session

$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staff_id = isset($_SESSION['staff_id']) ? $_SESSION['staff_id'] : null;
    $appointment_date = isset($_POST['date']) ? sanitize_input($_POST['date']) : null;
    $time_slots = isset($_POST['times']) ? json_decode($_POST['times'], true) : [];

    if (!$staff_id) {
        $response["message"] = "User not authenticated.";
    } elseif (!$appointment_date || empty($time_slots)) {
        $response["message"] = "Invalid date or no time slots selected.";
    } else {
        $result = add_doctor_schedule_ctr($staff_id, $appointment_date, $time_slots);
        
        if ($result) {
            $response["success"] = true;
            $response["message"] = "Schedule saved successfully.";
        } else {
            $response["message"] = "Failed to save schedule.";
        }
    }
} else {
    $response["message"] = "Invalid request method.";
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>