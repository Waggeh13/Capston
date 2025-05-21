<?php
require("../controllers/pharmacist_controller.php");

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['prescription_id']) && !empty($input['prescription_id'])) {
    $prescriptionId = $input['prescription_id'];
    
    try {
        $result = deletePrescriptionController($prescriptionId);
        
        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Could not delete prescription.']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid data received: prescription_id missing.']);
}
?>