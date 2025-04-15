<?php
require_once("../classes/telemedicine_class.php");

function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function patient_gettelemedicineappointmentsController($patient_id) {
    $telemedicine = new patient_telemedicine_class();
    return $telemedicine->get_telemedicine_appointments($patient_id);
}

function patient_getmeetingdetailsController($booking_id) {
    $telemedicine = new patient_telemedicine_class();
    return $telemedicine->get_meeting_details($booking_id);
}

function patient_savenotesController($booking_id, $notes) {
    $telemedicine = new patient_telemedicine_class();
    return $telemedicine->save_consultation_notes($booking_id, $notes);
}

function patient_endmeetingController($booking_id) {
    $telemedicine = new patient_telemedicine_class();
    return $telemedicine->end_meeting($booking_id);
}
?>