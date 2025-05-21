<?php
require("../controllers/department_controller.php");

if (isset($_POST['department_id']) && !empty($_POST['department_id'])) {
    $department_id = intval($_POST['department_id']);
    
    $result = deletedepartmentController($department_id);

    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Department deleted successfully'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to delete department'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'No department ID provided'
    ]);
}
exit();
?>
