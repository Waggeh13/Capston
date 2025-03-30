<?php
require("../controllers/admin_Staff_controller.php");

if (isset($_POST['Staff_id']) && !empty($_POST['Staff_id'])) {
    $Staff_id = intval($_POST['Staff_id']);
    
    // Call the delete function from the controller
    $result = deleteStaffController($Staff_id);

    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Staff deleted successfully'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to delete Staff'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'No Staff ID provided'
    ]);
}
exit();
?>
