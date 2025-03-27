<?php
require("../../../controllers/admin_controllers/admin_staff_controller.php");

if (isset($_POST['staff_id']) && !empty($_POST['staff_id'])) {
    $staff_id = intval($_POST['staff_id']);
    
    // Call the delete function from the controller
    $result = deletestaffController($product_id);

    if ($result) {
        // Redirect with a success message
        header("Location: ../view/admin_staff.html?message=staff deleted successfully");
    } else {
        // Redirect with an error message
        header("Location: ../view/admin_staff.html?error=Failed to delete staff");
    }
} else {
    // Redirect if no ID is provided
    header("Location: ../view/admin_staff.html.php?error=No staff ID provided");
}
exit();
?>
