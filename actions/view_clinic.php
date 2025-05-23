<?php
require("../controllers/clinic_controller.php");

header('Content-Type: application/json');

if (isset($_POST['clinic_id']) && !empty($_POST['clinic_id'])) {
    $clinicID = $_POST['clinic_id'];
    
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