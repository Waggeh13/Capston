<?php
require("../classes/patient_class.php");



function sanitize_input($input) {
    return htmlspecialchars(stripslashes(trim($input)));
}

// Function to add new patient
function addPatientController($patient_id, $first_name, $last_name, $dob, $gender, $weight, $address, $contact, $nextOfKin, $nextOfKinContact, $nextOfKinGender, $nextOfKinRelationship) {
    $patient= new patient_class();
    return $patient->addPatient($patient_id, $first_name, $last_name, $dob, $gender, $weight, $address, $contact, $nextOfKin, $nextOfKinContact, $nextOfKinGender, $nextOfKinRelationship);
}

// Function to delete patient
function deletePatientController($id) {
    $patient = new patient_class();
    return $patient->deletePatient($id);
}

// Function to view all patients
function viewPatientsController() {
    $patients = new patient_class();
    return $patients->getPatients();
}


// Function to view patients by ID
function viewPatientsByIDController($patient_id) {
    $patient = new patient_class();
    return $patient->getPatientsbyID($patient_id);
}

function ID_exists_ctr($patient_id) {
    $patient = new patient_class();
    return $patient->patient_ID_exists($patient_id);
}

function addUserController($patientId, $password, $userRole)
    {
        $patient = new patient_class();
        return $patient->addUser($patientId, $password, $userRole);
    }
    
// Function to update user
function updatePatientController($patient_id, $first_name, $last_name, $dob, $gender, $weight, $address, $contact, $nextOfKin, $nextOfKinContact, $nextOfKinGender, $nextOfKinRelationship) {
    $patient= new patient_class();
    return $patient->updatePatient($patient_id, $first_name, $last_name, $dob, $gender, $weight, $address, $contact, $nextOfKin, $nextOfKinContact, $nextOfKinGender, $nextOfKinRelationship);
}
?>
