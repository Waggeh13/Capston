<?php
require("../controllers/staff_controller.php");

header('Content-Type: application/json');

if (isset($_POST['staff_id']) && !empty($_POST['staff_id'])) {
    $staff_id = $_POST['staff_id'];
    
    
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