<?php
include("../controllers/clinic_controller.php");

$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clinicId = sanitize_input($_POST['editclinicId']);
    $clinicName= sanitize_input($_POST['editclinicName']);
    $department_id = sanitize_input($_POST['editDepartment']);

    $result = updateclinicController($clinicId, $clinicName, $department_id);
    if ($result) {
        $response["success"] = true;
        $response["message"] = "Clinic updated successfully.";
    } else {
        $response["success"] = false;
        $response["message"] = "Error: Unable to update clinic. Please try again.";
    }
} else {
    $response["message"] = "Invalid request method.";
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>
