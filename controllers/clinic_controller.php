<?php
require("../classes/clinic_class.php");

if (!function_exists('sanitize_input')) {
    function sanitize_input($input) {
        return htmlspecialchars(stripslashes(trim($input)));
    }
}

function addclinicController($clinic_id, $clinicName,$department_id ) {
    $clinic= new clinic_class();
    return $clinic->addclinic($clinic_id, $clinicName, $department_id);
}

function deleteclinicController($id) {
    $clinic = new clinic_class();
    return $clinic->deleteclinic($id);
}

function viewclinicsController() {
    $clinics = new clinic_class();
    return $clinics->getclinics();
}


function viewclinicsByIDController($clinic_id) {
    $clinic = new clinic_class();
    return $clinic->getclinicsbyID($clinic_id);
}

function clinic_exists_ctr($clinic_id) {
    $clinic = new clinic_class();
    return $clinic->clinic_ID_exists($clinic_id);
}

function updateclinicController($clinic_id, $clinicName,$department_id ) {
    $clinic= new clinic_class();
    return $clinic->updateclinic($clinic_id, $clinicName, $department_id);
}

?>
