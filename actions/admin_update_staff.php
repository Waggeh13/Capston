<?php
include("../controllers/admin_staff_controller.php");

$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staffId = sanitize_input($_POST['staffId']);
    $firstName = sanitize_input($_POST['firstName']);
    $lastName = sanitize_input($_POST['lastName']);
    $position = sanitize_input($_POST['position']);
    $department_id = sanitize_input($_POST['department']);
    $gender = sanitize_input($_POST['gender']);
    $contact = sanitize_input($_POST['contact']);
    $email = sanitize_input($_POST['email']);

    $result = updatestaffController($staffId, $firstName, $lastName, $gender, $position, $department_id, $contact,$email);
    if ($result) {
        $response["success"] = true;
        $response["message"] = "staff updated successfully.";
    } else {
        $response["success"] = false;
        $response["message"] = "Error: Unable to update staff. Please try again.";
    }
} else {
    $response["message"] = "Invalid request method.";
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>
