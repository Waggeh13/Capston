<?php
include("../controllers/clinic_controller.php");

$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clinicId = sanitize_input($_POST['clinicID']);

    // Check if ID already exists
    if (clinic_exists_ctr($clinicId)) {
        $response = [
            "success" => false,
            "message" => "ID already registered. Please Verify."
        ];
        echo json_encode($response);
        exit();
    }

    $clinicName = sanitize_input($_POST['clinicName']);
    $clinicdepartment = sanitize_input($_POST['department_id']);


    $result = addclinicController($clinicId, $clinicName, $clinicdepartment);
    
    if ($result) {
        $response["success"] = true;
        $response["message"] = "Clinic registered successfully.";
    } else {
        $response["success"] = false;
        $response["message"] = "Error: Unable to register clinic. Please try again.";
    }
} else {
    $response["message"] = "Invalid request method.";
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>