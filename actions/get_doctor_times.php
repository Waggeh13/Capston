<?php
include("../controllers/doc_schedule_controller.php");

$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staff_id = sanitize_input($_POST['staff_id']);
    $date = sanitize_input($_POST['date']);
    
    $times = get_doctor_schedule_for_date_ctr($staff_id, $date);
    
    if ($times) {
        $response["success"] = true;
        $response["times"] = $times;
    } else {
        $response["message"] = "No available times found.";
    }
} else {
    $response["message"] = "Invalid request method.";
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>