<?php
require("../classes/doc_schedule_class.php");

if (!function_exists('sanitize_input')) {
    function sanitize_input($input) {
        return htmlspecialchars(stripslashes(trim($input)));
    }
}

// Add doctor's schedule
function add_doctor_schedule_ctr($staff_id, $appointment_date, $time_slots) {
    $schedule = new schedule_class();
    return $schedule->add_doctor_schedule($staff_id, $appointment_date, $time_slots);
}

// Get doctor's schedule
function get_doctor_schedule_ctr($staff_id) {
    $schedule = new schedule_class();
    return $schedule->get_doctor_schedule($staff_id);
}
?>