<?php
require("../classes/prescription_class.php");

function sanitize_input($input) {
    return htmlspecialchars(stripslashes(trim($input)));
}

// Function to add new prescription
function prescription_controller($staff_id, $patient_fullname, $medication_date, $medicines, $dosages, $instructions) {
    $prescription = new prescription_class();
    return $prescription->prescription_form($staff_id, $patient_fullname, $medication_date, $medicines, $dosages, $instructions);
}

// Function to view all prescriptions
function viewprescriptionsController() {
    $prescriptions = new prescription_class();
    return $prescriptions->getprescriptions();
}

// Function to view prescription by ID
function viewprescriptionByIDController($prescription_id) {
    $prescription = new prescription_class();
    return $prescription->getprescriptionbyid($prescription_id);
}
?>