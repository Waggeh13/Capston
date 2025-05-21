<?php
require("../controllers/department_controller.php");

header('Content-Type: application/json');

if (isset($_POST['department_id']) && !empty($_POST['department_id'])) {
    $departmentID = $_POST['department_id'];
    
    
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