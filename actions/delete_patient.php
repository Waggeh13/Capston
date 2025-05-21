<?php
require("../controllers/patient_controller.php");

if (isset($_POST['patient_id']) && !empty($_POST['patient_id'])) {
    $patient_id = $_POST['patient_id'];
    
    $result = deletePatientController($patient_id);

    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Patient deleted successfully'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to delete patient'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'No patient ID provided'
    ]);
}
exit();
?>
