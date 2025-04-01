<?php
require("../controllers/department_controller.php");

// Set header first to ensure proper content type
header('Content-Type: application/json');

// Check if departmentID is set and not empty
if (isset($_POST['department_id']) && !empty($_POST['department_id'])) {
    $departmentID = $_POST['department_id']; // Fixed variable name
    
    // Turn off error display (or handle it properly in production)
    ini_set('display_errors', 0);
    
    try {
        $result = viewdepartmentsByIDController($departmentID);
        
        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(['error' => 'Could not retrieve department details.']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid data received.']);
}
?>