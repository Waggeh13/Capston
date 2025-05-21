<?php
session_start();
include("../controllers/login_controller.php");

$response = ['error' => false, 'message' => '', 'user_role' => '', 'user_id' => '', 'is_default_password' => false];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $user_id = sanitize_input($_POST['user_id']);
    $password = sanitize_input($_POST['password']);

    $response = login_user($user_id, $password);
} else {
    $response['error'] = true;
    $response['message'] = "Wrong request method. Please try again.";
}

header('Content-Type: application/json');
echo json_encode($response);
?>