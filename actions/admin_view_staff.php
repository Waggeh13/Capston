<?php
require("../controllers/admin_staff_controller.php");

// Set header first to ensure proper content type
header('Content-Type: application/json');

// Check if staff_id is set and not empty
if (isset($_POST['staff_id']) && !empty($_POST['staff_id'])) {
    $staff_id = $_POST['staff_id']; // Fixed variable name
    
    // Turn off error display (or handle it properly in production)
    ini_set('display_errors', 0);
    
    try {
        $result = viewstaffsByIDController($staff_id);
        
        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(['error' => 'Could not retrieve staff details.']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid data received.']);
}
?>