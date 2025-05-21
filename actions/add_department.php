<?php
include("../controllers/department_controller.php");

$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $departmentId = sanitize_input($_POST['departmentId']);

    if (department_exists_ctr($departmentId)) {
        $response = [
            "success" => false,
            "message" => "ID already registered. Please Verify."
        ];
        echo json_encode($response);
        exit();
    }

    $departmentName = sanitize_input($_POST['departmentName']);


    $result = adddepartmentController($departmentId, $departmentName);
    
    if ($result) {
        $response["success"] = true;
        $response["message"] = "Department registered successfully.";
    } else {
        $response["success"] = false;
        $response["message"] = "Error: Unable to register department. Please try again.";
    }
} else {
    $response["message"] = "Invalid request method.";
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>