<?php
require("../controllers/cashier_controller.php");
require_once("../settings/core.php");

// Set header to ensure proper content type
header('Content-Type: application/json');

// Check if required data is provided
$input = json_decode(file_get_contents('php://input'), true);
if (
    isset($input['dispensed_ids']) &&
    is_array($input['dispensed_ids']) &&
    isset($input['patient_id']) &&
    isset($input['prescription_id']) &&
    isset($input['total'])
) {
    $dispensed_ids = $input['dispensed_ids'];
    $patient_id = $input['patient_id'];
    $prescription_id = $input['prescription_id'];
    $total = $input['total'];
    $cashier_id = $_SESSION['user_id'];

    try {
        $result = processPaymentController($dispensed_ids, $patient_id, $prescription_id, $total, $cashier_id);
        
        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Could not process payment.']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid data received.']);
}
?>