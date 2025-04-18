<?php
require_once("../classes/doc_telemedicine_class.php");

function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function doctor_gettelemedicineappointmentsController($staff_id) {
    $telemedicine = new doctor_telemedicine_class();
    return $telemedicine->get_doctor_telemedicine_appointments($staff_id);
}

function doctor_getmeetingdetailsController($booking_id) {
    $telemedicine = new doctor_telemedicine_class();
    return $telemedicine->get_meeting_details($booking_id);
}

function doctor_savenotesController($booking_id, $notes) {
    $telemedicine = new doctor_telemedicine_class();
    return $telemedicine->save_consultation_notes($booking_id, $notes);
}

function doctor_endmeetingController($booking_id) {
    $telemedicine = new doctor_telemedicine_class();
    return $telemedicine->end_meeting($booking_id);
}
?>