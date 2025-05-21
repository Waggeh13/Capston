<?php
require("../controllers/cashier_controller.php");
require_once("../settings/core.php");

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
if (
    isset($input['dispensed_ids']) &&
    is_array($input['dispensed_ids']) &&
    !empty($input['dispensed_ids']) &&
    isset($input['patient_id']) &&
    isset($input['prescription_id']) &&
    isset($input['total'])
) {
    $dispensed_ids = array_map('intval', $input['dispensed_ids']);
    $patient_id = sanitize_input($input['patient_id']);
    $prescription_id = sanitize_input($input['prescription_id']);
    $total = floatval($input['total']);
    $cashier_id = $_SESSION['user_id'] ?? null;

    if (!$cashier_id) {
        echo json_encode(['error' => 'User not authenticated.']);
        exit;
    }

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
    echo json_encode(['error' => 'Invalid or incomplete data received.']);
}
?>