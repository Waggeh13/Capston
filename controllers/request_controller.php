<?php
require_once("../classes/request_class.php");

function sanitize_input($input) {
    if (is_array($input)) {
        return array_map('sanitize_input', $input);
    }
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    return $input;
}

function get_doctors_ctr() {
    $request = new request_class();
    return $request->get_doctors();
}

function request($patient_id, $doctor_id, $hospital_name) {
    $request = new request_class();
    return $request->make_request($patient_id, $doctor_id, $hospital_name);
}

function get_pending_requests_by_doctor_ctr($doctor_id) {
    $request = new request_class();
    return $request->get_pending_requests_by_doctor($doctor_id);
}

function update_request_status_ctr($request_id, $status) {
    $request = new request_class();
    return $request->update_request_status($request_id, $status);
}
?>