<?php

require("../../../controllers/admin_controllers/admin_patient_controller.php");




if (isset( $_POST['patient_id'])) {
    $patientt_id = $_POST['patient_id'];

    $result = viewPatientsByIDController($patient_id);

    if ($result) {
        echo json_encode($result);
    } else {
        echo json_encode(['Error'=> 'Could not retrive patient details.']);
    }
} else {
    echo json_encode(['error' => 'Invalid data received.']);
}
?>