<?php
include("../controllers/admin_controller.php");

$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adminId = sanitize_input($_POST['adminId']);

    // Check if ID already exists
    if (admin_exists_ctr($adminId)) {
        $response = [
            "success" => false,
            "message" => "ID already registered. Please Verify."
        ];
        echo json_encode($response);
        exit();
    }

    $firstName = sanitize_input($_POST['firstName']);
    $lastName = sanitize_input($_POST['lastName']);
    $contact = sanitize_input($_POST['contact']);
    $position = sanitize_input('Admin');
    $password = sanitize_input($_POST['default-password']);

    $result1 = addUserController($adminId, $password, $position);
    if($result1) {
        $result2 = addadminController($adminId, $firstName, $lastName,$contact, $position);
    }
    
    if ($result2) {
        $response["success"] = true;
        $response["message"] = "Admin registered successfully.";
    } else {
        $response["success"] = false;
        $response["message"] = "Error: Unable to register admin. Please try again.";
    }
} else {
    $response["message"] = "Invalid request method.";
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>