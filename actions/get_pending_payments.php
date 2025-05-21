<?php
require("../controllers/cashier_controller.php");

header('Content-Type: application/json');

try {
    $result = viewPendingPaymentsController();
    
    if ($result) {
        echo json_encode($result);
    } else {
        echo json_encode(['error' => 'No pending payments found.']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
?>