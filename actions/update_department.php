<?php
include("../controllers/department_controller.php");

$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $departmentId = sanitize_input($_POST['editdepartmentId']);
    $departmentName= sanitize_input($_POST['editdepartmentName']);

    $result = updatedepartmentController($departmentId, $departmentName);
    if ($result) {
        $response["success"] = true;
        $response["message"] = "Department updated successfully.";
    } else {
        $response["success"] = false;
        $response["message"] = "Error: Unable to update department. Please try again.";
    }
} else {
    $response["message"] = "Invalid request method.";
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>
