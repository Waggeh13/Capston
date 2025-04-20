<?php
require_once("../classes/get_prescription_class.php");

if (!function_exists('sanitize_input')) {
    function sanitize_input($input) {
        return htmlspecialchars(stripslashes(trim($input)));
    }
}

function get_patient_prescriptions_ctr($patient_id) {
    $prescription = new prescription_class();
    return $prescription->get_patient_prescriptions($patient_id);
}
?>