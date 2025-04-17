<?php
include("../controllers/admin_controller.php");

$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adminId = sanitize_input($_POST['adminId']);
    $firstName = sanitize_input($_POST['firstName']);
    $lastName = sanitize_input($_POST['lastName']);
    $contact = sanitize_input($_POST['contact']);
    $position = sanitize_input('Admin');
    $password = sanitize_input($_POST['default-password']);

    $result = updateadminController($adminId, $firstName, $lastName,$contact, $position);
    if ($result) {
        $response["success"] = true;
        $response["message"] = "admin updated successfully.";
    } else {
        $response["success"] = false;
        $response["message"] = "Error: Unable to update admin. Please try again.";
    }
} else {
    $response["message"] = "Invalid request method.";
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>
