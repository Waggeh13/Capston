<?php
require("../classes/pharmacist_class.php");

if (!function_exists('sanitize_input')) {
    function sanitize_input($input) {
        return htmlspecialchars(stripslashes(trim($input)));
    }
}
function viewPendingPrescriptionsController() {
    $prescription = new Prescription_class();
    return $prescription->getPendingPrescriptions();
}

function viewPrescriptionByIdController($prescription_id) {
    $prescription = new Prescription_class();
    return $prescription->getPrescriptionById($prescription_id);
}

function dispenseMedicationController($prescription_id, $patient_id, $medications, $pharmacist_id) {
    $prescription = new Prescription_class();
    return $prescription->dispenseMedication($prescription_id, $patient_id, $medications, $pharmacist_id);
}

function deletePrescriptionController($prescription_id) {
    $prescription = new Prescription_class();
    return $prescription->deletePrescription($prescription_id);
}
?>