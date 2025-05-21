<?php
require_once('../settings/core.php');
require_once('../classes/message_class.php');

header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

error_log("search_users.php session: " . json_encode($_SESSION));
error_log("search_users.php input: " . file_get_contents('php://input'));

$input = json_decode(file_get_contents('php://input'), true);
if (!$input || !isset($input['query']) || !isset($input['user_role'])) {
    error_log("search_users.php: Invalid or missing query/user_role");
    echo json_encode([
        'success' => false,
        'users' => [],
        'error' => 'Invalid or missing query/user_role'
    ]);
    exit;
}

$query = trim($input['query']);
$user_role = trim($input['user_role']);


if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || strcasecmp($_SESSION['user_role'], 'Doctor') !== 0) {
    error_log("search_users.php: Invalid session or role");
    echo json_encode([
        'success' => false,
        'users' => [],
        'error' => 'Invalid session or user role'
    ]);
    exit;
}

$db = new Message_class();
if (!$db->db_conn()) {
    error_log("search_users.php: Database connection failed");
    echo json_encode([
        'success' => false,
        'users' => [],
        'error' => 'Database connection failed'
    ]);
    exit;
}

$result = $db->searchUsers($query, $user_role);

error_log("search_users.php response: " . json_encode($result));

echo json_encode($result);
?>