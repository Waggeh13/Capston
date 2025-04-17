<?php
require("../controllers/admin_controller.php");

if (isset($_POST['admin_id']) && !empty($_POST['admin_id'])) {
    $admin_id = intval($_POST['admin_id']);
    
    // Call the delete function from the controller
    $result = deleteadminController($admin_id);

    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Admin deleted successfully'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to delete admin'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'No admin ID provided'
    ]);
}
exit();
?>
