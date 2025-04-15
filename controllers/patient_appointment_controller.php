<?php
require_once("../classes/patient_appointment_class.php");

function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function patient_bookappointmentController($patient_id, $staff_id, $appointmentDate, $appointmentTime, $appointmentType, $clinic_id, $timeslot_id) {
    $appointment = new patient_appointment_class();
    return $appointment->book_appointment($patient_id, $staff_id, $appointmentDate, $appointmentTime, $appointmentType, $clinic_id, $timeslot_id);
}

function patient_updateappointmentController($booking_id, $patient_id, $staff_id, $appointmentDate, $appointmentTime, $appointmentType, $clinic_id, $timeslot_id) {
    $appointment = new patient_appointment_class();
    return $appointment->update_appointment($booking_id, $patient_id, $staff_id, $appointmentDate, $appointmentTime, $appointmentType, $clinic_id, $timeslot_id);
}

function patient_deleteappointmentController($booking_id) {
    $appointment = new patient_appointment_class();
    return $appointment->delete_appointment($booking_id);
}

function patient_getappointmentsController($patient_id) {
    $appointment = new patient_appointment_class();
    return $appointment->get_appointments($patient_id);
}

function patient_getappointmentController($booking_id) {
    $appointment = new patient_appointment_class();
    return $appointment->get_appointment($booking_id);
}
?>