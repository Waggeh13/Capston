<?php
require("../controllers/receipt_controller.php");

header('Content-Type: application/json');

if (!isset($_GET['receipt_id'])) {
    error_log('get_receipt_details: No receipt_id provided');
    echo json_encode(['error' => 'Receipt ID is required.']);
    exit;
}

$receipt_id = $_GET['receipt_id'];
error_log('get_receipt_details: Received receipt_id: ' . $receipt_id);

try {
    $result = getReceiptDetailsController($receipt_id);
    
    if ($result) {
        echo json_encode($result);
    } else {
        error_log('get_receipt_details: No receipt found for receipt_id: ' . $receipt_id);
        echo json_encode(['error' => 'Receipt not found.']);
    }
} catch (Exception $e) {
    error_log('get_receipt_details: Server error: ' . $e->getMessage());
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
?>