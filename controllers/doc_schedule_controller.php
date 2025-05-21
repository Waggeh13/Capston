<?php
require("../classes/doc_schedule_class.php");

if (!function_exists('sanitize_input')) {
    function sanitize_input($input) {
        return htmlspecialchars(stripslashes(trim($input)));
    }
}

function add_doctor_schedule_ctr($staff_id, $appointment_date, $time_slots) {
    $schedule = new schedule_class();
    return $schedule->add_doctor_schedule($staff_id, $appointment_date, $time_slots);
}

function get_doctor_schedule_for_date_ctr($staff_id, $date) {
    $schedule = new schedule_class();
    return $schedule->get_doctor_schedule_for_date($staff_id, $date);
}

function get_doctor_schedule_ctr($staff_id) {
    $schedule = new schedule_class();
    return $schedule->get_doctor_schedule($staff_id);
}

function get_doctors_with_schedules_ctr() {
    $schedule = new schedule_class();
    return $schedule->get_doctors_with_schedules();
}

function get_doctor_available_dates_ctr($staff_id) {
    $schedule = new schedule_class();
    return $schedule->get_doctor_available_dates($staff_id);
}
?>