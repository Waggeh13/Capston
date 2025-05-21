<?php
include("../controllers/admin_controller.php");

$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $original_admin_id = sanitize_input($_POST['originalAdminId']);
    $new_admin_id = sanitize_input($_POST['adminId']);
    $first_name = sanitize_input($_POST['firstName']);
    $last_name = sanitize_input($_POST['lastName']);
    $contact = sanitize_input($_POST['contact']);

    $result = updateadminController($original_admin_id, $new_admin_id, $first_name, $last_name, $contact);
    if ($result) {
        $response["success"] = true;
        $response["message"] = "Admin updated successfully.";
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