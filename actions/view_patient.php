<?php
require("../controllers/patient_controller.php");

header('Content-Type: application/json');

if (isset($_POST['patient_id']) && !empty($_POST['patient_id'])) {
    $patient_id = $_POST['patient_id'];

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