<?php
require("../controllers/patient_controller.php");

// Set header first to ensure proper content type
header('Content-Type: application/json');

// Check if patient_id is set and not empty
if (isset($_POST['patient_id']) && !empty($_POST['patient_id'])) {
    $patient_id = $_POST['patient_id']; // Fixed variable name
    
    // Turn off error display (or handle it properly in production)
    ini_set('display_errors', 0);
    
    try {
        $result = viewPatientsByIDController($patient_id);
        
        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(['error' => 'Could not retrieve patient details.']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid data received.']);
}
?>