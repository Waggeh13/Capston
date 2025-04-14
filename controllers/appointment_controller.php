<?php
require("../classes/appointment_class.php");

if (!function_exists('sanitize_input')) {
    function sanitize_input($input) {
        return htmlspecialchars(stripslashes(trim($input)));
    }
}

function bookappointmentController($patientName, $staff_id, $appointmentDate, $appointmentTime, $appointmentType, $clinic_id, $timeslot_id) {
    $appointment = new appointment_class();
    return $appointment->book_appointment($patientName, $staff_id, $appointmentDate, $appointmentTime, $appointmentType, $clinic_id, $timeslot_id);
}

function updateappointmentController($booking_id, $patientName, $staff_id, $appointmentDate, $appointmentTime, $appointmentType, $clinic_id, $timeslot_id) {
    $appointment = new appointment_class();
    return $appointment->update_appointment($booking_id, $patientName, $staff_id, $appointmentDate, $appointmentTime, $appointmentType, $clinic_id, $timeslot_id);
}

function deleteappointmentController($booking_id) {
    $appointment = new appointment_class();
    return $appointment->delete_appointment($booking_id);
}

function getappointmentsController() {
    $appointment = new appointment_class();
    return $appointment->get_appointments();
}

function getappointmentController($booking_id) {
    $appointment = new appointment_class();
    return $appointment->get_appointment($booking_id);
}

function updateappointmentstatusController($booking_id, $status) {
    $appointment = new appointment_class();
    return $appointment->update_appointment_status($booking_id, $status);
}

function getdoctorappointmentsController($staff_id, $date) {
    $appointment = new appointment_class();
    return $appointment->get_doctor_appointments($staff_id, $date);
}

function getpatientappointmentsController($patient_id) {
    $appointment = new appointment_class();
    return $appointment->get_patient_appointments($patient_id);
}
?>