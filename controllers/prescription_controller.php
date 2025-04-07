<?php
require("../classes/prescription_class.php");



function sanitize_input($input) {
    return htmlspecialchars(stripslashes(trim($input)));
}

// Function to add new patient
function prescription_controller($doctor_fullname, $patient_fullname, $medication_date, $medicines, $dosages, $instructions) {
    $prescription = new prescription_class();
    return $prescription->prescription_form($doctor_fullname, $patient_fullname, $medication_date, $medicines, $dosages, $instructions);
}

// Function to view all products
function viewprescriptionsController() {
    $patients = new lab_class();
    return $patients->getprescriptions();
}


// Function to view patients by ID
function viewprescriptionByIDController($prescription_id) {
    $patient = new lab_class();
    return $patient->getprescriptionbyid($prescription_id);
}
?>
