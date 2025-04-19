<?php
require_once('../settings/core.php');
require_once('../classes/message_class.php');

header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Debug session and request
error_log("send_message_action.php session: " . json_encode($_SESSION));
error_log("send_message_action.php input: " . file_get_contents('php://input'));

// Get POST data
$input = json_decode(file_get_contents('php://input'), true);
if (!$input || !isset($input['sender_id']) || !isset($input['receiver_id']) || !isset($input['message'])) {
    error_log("send_message_action.php: Invalid or missing sender_id/receiver_id/message");
    echo json_encode([
        'success' => false,
        'message' => 'Invalid or missing sender_id/receiver_id/message'
    ]);
    exit;
}

$sender_id = trim($input['sender_id']);
$receiver_id = trim($input['receiver_id']);
$message = trim($input['message']);

// Validate session
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || 
    !in_array(strtolower($_SESSION['user_role']), ['doctor', 'patient'])) {
    error_log("send_message_action.php: Invalid session or role");
    echo json_encode([
        'success' => false,
        'message' => 'Invalid session or user role'
    ]);
    exit;
}

// Ensure sender_id matches logged-in user
if ($sender_id !== $_SESSION['user_id']) {
    error_log("send_message_action.php: Sender ID does not match session user_id");
    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized sender ID'
    ]);
    exit;
}

// Initialize message class
$db = new Message_class();
if (!$db->db_conn()) {
    error_log("send_message_action.php: Database connection failed");
    echo json_encode([
        'success' => false,
        'message' => 'Database connection failed'
    ]);
    exit;
}

// Send message
$result = $db->sendMessage($sender_id, $receiver_id, $message);

// Debug response
error_log("send_message_action.php response: " . json_encode($result));

echo json_encode($result);
?>