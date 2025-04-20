<?php
require("../classes/pharmacist_class.php");

if (!function_exists('sanitize_input')) {
    function sanitize_input($input) {
        return htmlspecialchars(stripslashes(trim($input)));
    }
}

// Function to view all pending prescriptions
function viewPendingPrescriptionsController() {
    $prescription = new Prescription_class();
    return $prescription->getPendingPrescriptions();
}

// Function to view prescription by ID
function viewPrescriptionByIdController($prescription_id) {
    $prescription = new Prescription_class();
    return $prescription->getPrescriptionById($prescription_id);
}

// Function to dispense medications
function dispenseMedicationController($prescription_id, $patient_id, $medications, $pharmacist_id) {
    $prescription = new Prescription_class();
    return $prescription->dispenseMedication($prescription_id, $patient_id, $medications, $pharmacist_id);
}

// Function to delete a prescription
function deletePrescriptionController($prescription_id) {
    $prescription = new Prescription_class();
    return $prescription->deletePrescription($prescription_id);
}
?>