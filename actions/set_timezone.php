<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['timezone'])) {
    $timezone = filter_var($_POST['timezone'], FILTER_SANITIZE_STRING);
    if (in_array($timezone, timezone_identifiers_list())) {
        $_SESSION['client_timezone'] = $timezone;
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid timezone']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>