<?php
require("../classes/admin_class/admin_patient_class.php");



function sanitize_input($input) {
    return htmlspecialchars(stripslashes(trim($input)));
}

// Function to add new patient
function addPatientController($patient_id, $first_name, $last_name, $dob, $gender, $weight, $address, $contact, $nextOfKin, $nextOfKinContact, $nextOfKinGender, $nextOfKinRelationship) {
    $patient= new admin_patient_class();
    return $patient->addPatient($patient_id, $first_name, $last_name, $dob, $gender, $weight, $address, $contact, $nextOfKin, $nextOfKinContact, $nextOfKinGender, $nextOfKinRelationship);
}

// Function to delete product
function deletePatientController($id) {
    $patient = new admin_patient_class();
    return $patient->deletePatient($id);
}

// Function to view all products
function viewPatientsController() {
    $patients = new admin_patient_class();
    return $patients->getPatients();
}


// Function to view patients by ID
function viewPatientsByIDController($patient_id) {
    $patient = new admin_patient_class();
    return $patient->getPatientsbyID($patient_id);
}

function ID_exists_ctr($patient_id) {
    $patient = new admin_patient_class();
    return $patient->patient_ID_exists($patient_id);
}

function addUserController($patientId, $password, $userRole)
    {
        $patient = new admin_patient_class();
        return $patient->addUser($patientId, $password, $userRole);
    }
?>
