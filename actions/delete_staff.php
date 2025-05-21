<?php
require("../controllers/staff_controller.php");
if (isset($_POST['staff_id']) && !empty($_POST['staff_id'])) {
    $staff_id = $_POST['staff_id'];
    
    $result = deleteStaffController($staff_id);

    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Staff deleted successfully'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to delete staff'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'No staff ID provided'
    ]);
}
exit();
?>