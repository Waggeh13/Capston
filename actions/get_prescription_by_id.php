<?php
require("../controllers/pharmacist_controller.php");

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['prescription_id']) && !empty($input['prescription_id'])) {
    $prescriptionId = $input['prescription_id'];
    
    try {
        $result = viewPrescriptionByIdController($prescriptionId);
        
        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(['error' => 'Could not retrieve prescription details.']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid data received: prescription_id missing.']);
}
?>