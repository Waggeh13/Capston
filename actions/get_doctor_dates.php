<?php
include("../controllers/doc_schedule_controller.php");

$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staff_id = sanitize_input($_POST['staff_id']);
    
    $dates = get_doctor_available_dates_ctr($staff_id);
    
    if ($dates) {
        $response["success"] = true;
        $response["dates"] = $dates;
    } else {
        $response["message"] = "No available dates found.";
    }
} else {
    $response["message"] = "Invalid request method.";
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>