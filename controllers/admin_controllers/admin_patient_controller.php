<?php
require("../../classes/admin_class/admin_patient_class.php");



function sanitize_input($input) {
    return htmlspecialchars(stripslashes(trim($input)));
}

// Function to add new patient
function addPatientController($product_title, $brand, $category, $price, $description, $image, $keywords) {
    $patient= new admin_patient_class();
    return $patient->addPatient($product_title, $brand, $category, $price, $description, $image, $keywords);
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
?>
