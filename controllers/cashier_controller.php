<?php
require("../classes/cashier_class.php");

if (!function_exists('sanitize_input')) {
    function sanitize_input($input) {
        return htmlspecialchars(stripslashes(trim($input)));
    }
}
function viewPendingPaymentsController() {
    $cashier = new Cashier_class();
    return $cashier->getPendingPayments();
}
function processPaymentController($dispensed_ids, $patient_id, $prescription_id, $total, $cashier_id) {
    $cashier = new Cashier_class();
    return $cashier->processPayment($dispensed_ids, $patient_id, $prescription_id, $total, $cashier_id);
}

function viewRecentPaymentsController() {
    $cashier = new Cashier_class();
    return $cashier->getRecentPayments();
}
?>