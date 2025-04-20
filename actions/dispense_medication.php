<?php
require("../controllers/pharmacist_controller.php");
require_once("../settings/core.php");

// Set header first to ensure proper content type
header('Content-Type: application/json');

// Check if required data is provided
$input = json_decode(file_get_contents('php://input'), true);
if (
    isset($input['prescription_id']) &&
    isset($input['patient_id']) &&
    isset($input['medications']) &&
    is_array($input['medications'])
) {
    $prescriptionId = $input['prescription_id'];
    $patientId = $input['patient_id'];
    $medications = $input['medications'];
    $pharmacistId = $_SESSION['user_id'];

    try {
        $result = dispenseMedicationController($prescriptionId, $patientId, $medications, $pharmacistId);
        
        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Could not dispense medications.']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid data received.']);
}
?>