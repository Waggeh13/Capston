<?php
include("../controllers/staff_controller.php");

$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staffId = sanitize_input($_POST['staffId']);

    if (staff_exists_ctr($staffId)) {
        $response = [
            "success" => false,
            "message" => "ID already registered. Please Verify."
        ];
        echo json_encode($response);
        exit();
    }

    $firstName = sanitize_input($_POST['firstName']);
    $lastName = sanitize_input($_POST['lastName']);
    $position = sanitize_input($_POST['position']);
    $department = sanitize_input($_POST['department']);
    $gender = sanitize_input($_POST['gender']);
    $contact = sanitize_input($_POST['contact']);
    $email = sanitize_input($_POST['email']);
    $password = sanitize_input($_POST['default-password']);

    $result1 = addUserController($staffId, $password, $position);
    if($result1) {
        $result2 = addstaffController($staffId, $firstName, $lastName,$gender, $position,$department, $contact, $email);
    }
    
    if ($result2) {
        $response["success"] = true;
        $response["message"] = "Staff registered successfully.";
    } else {
        $response["success"] = false;
        $response["message"] = "Error: Unable to register staff. Please try again.";
    }
} else {
    $response["message"] = "Invalid request method.";
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>