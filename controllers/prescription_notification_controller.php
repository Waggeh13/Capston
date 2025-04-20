<?php
require_once("../classes/prescription_notification_class.php");

if (!function_exists('sanitize_input')) {
    function sanitize_input($input) {
        return htmlspecialchars(stripslashes(trim($input)));
    }
}

function save_notification_preference_ctr($medication_id, $patient_id, $enabled) {
    $notification = new prescription_notification_class();
    return $notification->save_notification_preference($medication_id, $patient_id, $enabled);
}

function save_notification_time_ctr($medication_id, $patient_id, $notification_time, $interval_hours, $client_timezone = 'UTC') {
    $notification = new prescription_notification_class();
    return $notification->save_notification_time($medication_id, $patient_id, $notification_time, $interval_hours, $client_timezone);
}

function delete_notification_time_ctr($notification_id) {
    $notification = new prescription_notification_class();
    return $notification->delete_notification_time($notification_id);
}

function get_notification_settings_ctr($medication_id, $patient_id) {
    $notification = new prescription_notification_class();
    return $notification->get_notification_settings($medication_id, $patient_id);
}

function get_patient_notification_times_ctr($patient_id) {
    $notification = new prescription_notification_class();
    return $notification->get_patient_notification_times($patient_id);
}
?>