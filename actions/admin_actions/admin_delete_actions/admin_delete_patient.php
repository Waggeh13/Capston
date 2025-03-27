<?php
require("../../../controllers/admin_controllers/admin_patient_controller.php");

if (isset($_POST['patient_id']) && !empty($_POST['patient_id'])) {
    $patient_id = intval($_POST['patient_id']);
    
    // Call the delete function from the controller
    $result = deletePatientController($product_id);

    if ($result) {
        // Redirect with a success message
        header("Location: ../view/admin_patient.html?message=Patient deleted successfully");
    } else {
        // Redirect with an error message
        header("Location: ../view/admin_patient.html?error=Failed to delete patient");
    }
} else {
    // Redirect if no ID is provided
    header("Location: ../view/admin_patient.html.php?error=No patient ID provided");
}
exit();
?>
