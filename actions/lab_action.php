<?php
session_start();
require_once("../controllers/lab_controller.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user is logged in and has the correct role
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'Lab Technician') {
        echo json_encode(["success" => false, "message" => "Unauthorized: You must be logged in as a lab technician"]);
        exit;
    }

    $lab_id = isset($_POST['lab_id']) ? $_POST['lab_id'] : null;
    $lab_tech_id = $_SESSION['user_id']; // Retrieve lab_tech_id from session

    if (!$lab_id || !$lab_tech_id) {
        echo json_encode(["success" => false, "message" => "Invalid lab ID or lab technician ID"]);
        exit;
    }

    // Collect results dynamically from form inputs named test_<test_type_id>
    $results = [];
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'test_') === 0 && !empty($value)) {
            $test_type_id = str_replace('test_', '', $key);
            if (is_numeric($test_type_id)) {
                $results[$test_type_id] = $value;
            }
        }
    }

    if (empty($results)) {
        echo json_encode(["success" => false, "message" => "No test results provided"]);
        exit;
    }

    $specimen_received_by = isset($_POST['specimen_received_by']) ? $_POST['specimen_received_by'] : '';
    $specimen_date = isset($_POST['specimen_date']) ? $_POST['specimen_date'] : null;
    $specimen_time = isset($_POST['specimen_time']) ? $_POST['specimen_time'] : null;
    $sample_accepted = isset($_POST['sample_accepted']) ? strtoupper($_POST['sample_accepted']) : 'YES';
    $lab_tech_signature = isset($_POST['lab_tech_signature']) ? $_POST['lab_tech_signature'] : '';
    $lab_tech_date = isset($_POST['lab_tech_date']) ? $_POST['lab_tech_date'] : null;
    $supervisor_signature = isset($_POST['supervisor_signature']) ? $_POST['supervisor_signature'] : '';
    $supervisor_date = isset($_POST['supervisor_date']) ? $_POST['supervisor_date'] : null;

    $controller = new LabController();
    $result = $controller->submitLabResults(
        $lab_id,
        $lab_tech_id,
        $results,
        $specimen_received_by,
        $specimen_date,
        $specimen_time,
        $sample_accepted,
        $lab_tech_signature,
        $lab_tech_date,
        $supervisor_signature,
        $supervisor_date
    );

    echo json_encode($result);
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
?>