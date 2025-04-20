<?php
require("../classes/cashier_class.php");

if (!function_exists('sanitize_input')) {
    function sanitize_input($input) {
        return htmlspecialchars(stripslashes(trim($input)));
    }
}

// Function to get receipt details by receipt_id
function getReceiptDetailsController($receipt_id) {
    $cashier = new Cashier_class();
    return $cashier->getReceiptDetails($receipt_id);
}
?>