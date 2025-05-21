<?php
include("../controllers/patient_controller.php");

$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $original_patient_id = sanitize_input($_POST['originalpatientId']);
    $patientId = sanitize_input($_POST['patient_id']);
    $firstName = sanitize_input($_POST['first_name']);
    $lastName = sanitize_input($_POST['last_name']);
    $dob = sanitize_input($_POST['DOB']);
    $weight = sanitize_input($_POST['weight']);
    $contact = sanitize_input($_POST['contact']);
    $gender = sanitize_input($_POST['gender']);
    $nextOfKin= sanitize_input($_POST['nextofkinname']);
    $nextOfKinContact = sanitize_input($_POST['nextofkincontact']);
    $nextOfKinGender = sanitize_input($_POST['nextofkingender']);
    $nextOfKinRelationship = sanitize_input($_POST['nextofkinrelationship']);
    $address = sanitize_input($_POST['address']);

    if($original_patient_id== $patientId)
    {
        $result = updatePatientController($patientId, $firstName, $lastName, $dob, $gender, $weight, $address, $contact, $nextOfKin, $nextOfKinContact, $nextOfKinGender, $nextOfKinRelationship);
    }
    else{
        $idchange = update_id($original_patient_id, $patientId);
        if($idchange)
        {
            $result = updatePatientController($patientId, $firstName, $lastName, $dob, $gender, $weight, $address, $contact, $nextOfKin, $nextOfKinContact, $nextOfKinGender, $nextOfKinRelationship);
        }
    }
    if ($result) {
        $response["success"] = true;
        $response["message"] = "Patient updated successfully.";
    } else {
        $response["success"] = false;
        $response["message"] = "Error: Unable to update patient. Please try again.";
    }
} else {
    $response["message"] = "Invalid request method.";
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>
