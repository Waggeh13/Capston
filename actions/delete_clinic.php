<?php
require("../controllers/clinic_controller.php");

if (isset($_POST['clinic_id']) && !empty($_POST['clinic_id'])) {
    $clinic_id = intval($_POST['clinic_id']);
    
    $result = deleteclinicController($clinic_id);

    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Clinic deleted successfully'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to delete clinic'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'No clinic ID provided'
    ]);
}
exit();
?>
