<?php
include("../controllers/admin_controllers/admin_patient_controller.php");

$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patientId = sanitize_input($_POST['patientId']);

    // Check if email already exists
    if (ID_exists_ctr($patientId)) {
        $response["message"] = "ID already registered. Please Verify.";
        echo json_encode($response);
        exit();
    }

    $patientId = sanitize_input($_POST['patientId']);
    $firstName = sanitize_input($_POST['firstName']);
    $lastName = sanitize_input($_POST['lastName']);
    $dob = sanitize_input($_POST['dob']);
    $weight = sanitize_input($_POST['weight']);
    $contact = sanitize_input($_POST['contact']);
    $gender = sanitize_input($_POST['gender']);
    $nextOfKin= sanitize_input($_POST['nextOfKin']);
    $nextOfKinContact = sanitize_input($_POST['nextOfKinContact']);
    $nextOfKinGender = sanitize_input($_POST['nextOfKinGender']);
    $nextOfKinRelationship = sanitize_input($_POST['nextOfKinRelationship']);
    $password = sanitize_input($_POST['default-password']);
    $address = sanitize_input($_POST['address']);
    $userRole = sanitize_input('Patient');

    $result1 = addUserController($patientId, $password, $userRole);
    if($result1)
    {
        $result2 = addPatientController($patient_id,$first_name,$last_name,$dob,$gender,$weight,$address,$contact,$nextOfKin,$nextOfKinContact,$nextOfKinGender,$nextOfKinRelationship);
    }
    if ($result2) {
        $response["success"] = true;
        $response["message"] = "Customer registered successfully.";
    } else {
        $response["success"] = false;
        $response["message"] = "Error: Unable to register customer. Please try again.";
    }
} else {
    $response["message"] = "Invalid request method.";
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>
