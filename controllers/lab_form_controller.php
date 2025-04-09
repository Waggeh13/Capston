<?php
require("../classes/lab_class.php");

function sanitize_input($input) {
    return htmlspecialchars(stripslashes(trim($input)));
}

function addrequestcontroller($doctor_fullname, $patient_fullname, $testRequests, $susdiag, $signature, $ext, $request_date) {
    $lab = new lab_class();
    return $lab->requestform($doctor_fullname, $patient_fullname, $testRequests, $susdiag, $signature, $ext, $request_date);
}

function viewlabresultController() {
    $lab = new lab_class();
    return $lab->getlabresult();
}

function viewlabresultByIDController($lab_id) {
    $lab = new lab_class();
    return $lab->getlabresultbyid($lab_id);
}

function getTestTypesController() {
    $lab = new lab_class();
    return $lab->getTestTypes();
}
?>