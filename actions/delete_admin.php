<?php
require("../controllers/admin_controller.php");

if (isset($_POST['admin_id']) && !empty($_POST['admin_id'])) {
    $admin_id = $_POST['admin_id'];
    
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
        'message' => 'No patient ID provided'
    ]);
}
exit();
?>
