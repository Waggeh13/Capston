<?php
require("../controllers/pharmacist_controller.php");

// Set header to ensure proper content type
header('Content-Type: application/json');

// Get JSON input from the request body
$input = json_decode(file_get_contents('php://input'), true);

// Check if prescription_id is set and not empty
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