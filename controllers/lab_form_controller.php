<?php
require("../classes/lab_class.php");



function sanitize_input($input) {
    return htmlspecialchars(stripslashes(trim($input)));
}

// Function to add new patient
function addrequestcontroller($doctor_fullname, $patient_fullname, $lab_test, $susdiag, $signature, $ext, $request_date) {
    $patient= new lab_class();
    return $patient->requestform($doctor_fullname, $patient_fullname, $lab_test,  $susdiag, $signature, $ext, $request_date);
}

// Function to view all products
function viewlabresultController() {
    $patients = new lab_class();
    return $patients->getlabresult();
}


// Function to view patients by ID
function viewlabresultByIDController($lab_id) {
    $patient = new lab_class();
    return $patient->getlabresultbyid($lab_id);
}
?>
