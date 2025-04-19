<?php
require_once('../settings/core.php');
require_once('../classes/patient_doctor_search_class.php');

header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Debug session and request
error_log("patient_search_doctor_action.php session_id: " . session_id());
error_log("patient_search_doctor_action.php session: " . json_encode($_SESSION));
error_log("patient_search_doctor_action.php input: " . file_get_contents('php://input'));

// Get POST data
$input = json_decode(file_get_contents('php://input'), true);
if (!$input || !isset($input['query'])) {
    error_log("patient_search_doctor_action.php: Invalid or missing query");
    echo json_encode([
        'success' => false,
        'doctors' => [],
        'error' => 'Invalid or missing query'
    ]);
    exit;
}

$query = trim($input['query']);

// Validate session
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || strcasecmp($_SESSION['user_role'], 'Patient') !== 0) {
    error_log("patient_search_doctor_action.php: Invalid session - user_id: " . ($_SESSION['user_id'] ?? 'unset') . ", user_role: " . ($_SESSION['user_role'] ?? 'unset'));
    echo json_encode([
        'success' => false,
        'doctors' => [],
        'error' => 'Invalid session or user role'
    ]);
    exit;
}

// Initialize search class
$search = new patient_doctor_search_class();
if (!$search->db_conn()) {
    error_log("patient_search_doctor_action.php: Database connection failed");
    echo json_encode([
        'success' => false,
        'doctors' => [],
        'error' => 'Database connection failed'
    ]);
    exit;
}

// Search doctors
$result = $search->searchDoctors($query);

// Debug response
error_log("patient_search_doctor_action.php response: " . json_encode($result));

echo json_encode($result);
?>