<?php
require("../controllers/admin_controller.php");

// Set header first to ensure proper content type
header('Content-Type: application/json');

// Check if admin_id is set and not empty
if (isset($_POST['admin_id']) && !empty($_POST['admin_id'])) {
    $admin_id = $_POST['admin_id'];
    
    try {
        $result = viewadminsByIDController($admin_id);
        
        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(['error' => 'Could not retrieve admin details.']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid data received.']);
}
?>