<?php
require("../controllers/clinic_controller.php");

// Set header first to ensure proper content type
header('Content-Type: application/json');

// Check if clinicID is set and not empty
if (isset($_POST['clinic_id']) && !empty($_POST['clinic_id'])) {
    $clinicID = $_POST['clinic_id']; // Fixed variable name
    
    // Turn off error display (or handle it properly in production)
    ini_set('display_errors', 0);
    
    try {
        $result = viewclinicsByIDController($clinicID);
        
        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(['error' => 'Could not retrieve clinic details.']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid data received.']);
}
?>